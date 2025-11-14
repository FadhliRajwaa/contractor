<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    /**
     * Display users list
     */
    public function index()
    {
        $users = User::with('roles')
            ->latest()
            ->paginate(15);

        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Store a new user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'exists:roles,name'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        // Generate password if not provided
        $password = $validated['password'] ?? Str::random(12);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($password),
            'notes' => $validated['notes'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        $user->assignRole($validated['role']);

        return redirect()
            ->route('users.index')
            ->with('success', '✅ User baru berhasil ditambahkan! Welcome ' . $user->name . '! Password: ' . $password);
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'exists:roles,name'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'notes' => $validated['notes'] ?? null,
            'is_active' => $validated['is_active'] ?? $user->is_active,
        ]);

        // Update password if provided
        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        // Sync role
        $user->syncRoles([$validated['role']]);

        return redirect()
            ->route('users.index')
            ->with('success', '🔄 User ' . $user->name . ' berhasil diperbarui!');
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', '🗑️ User ' . $user->name . ' berhasil dihapus!');
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->route('users.index')
            ->with('success', ($user->is_active ? '✅' : '❌') . ' User ' . $user->name . ' berhasil ' . $status . '!');
    }

    /**
     * Reset user password
     */
    public function resetPassword(User $user)
    {
        $newPassword = Str::random(12);
        $user->update(['password' => Hash::make($newPassword)]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Password berhasil direset! Password baru: ' . $newPassword);
    }
}
