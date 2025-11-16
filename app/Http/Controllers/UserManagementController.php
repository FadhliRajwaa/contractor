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
     * Role Hierarchy Definition (highest to lowest)
     * Lower numbers = higher privilege
     */
    private const ROLE_HIERARCHY = [
        'superadmin' => 1,
        'administrator' => 2,
        'admin_kontraktor' => 3,
        'user_kontraktor' => 4,
        'customer' => 5,
    ];

    /**
     * Check if current user can manage target user based on role hierarchy
     */
    private function canManageUser(User $targetUser): bool
    {
        $currentUserRole = auth()->user()->roles->first()->name ?? 'customer';
        $targetUserRole = $targetUser->roles->first()->name ?? 'customer';
        
        $currentLevel = self::ROLE_HIERARCHY[$currentUserRole] ?? 999;
        $targetLevel = self::ROLE_HIERARCHY[$targetUserRole] ?? 999;
        
        // Can only manage users with LOWER privilege (higher number)
        return $currentLevel < $targetLevel;
    }

    /**
     * Get roles that current user is allowed to see/manage
     * Only Superadmin can manage same-level roles. Others can only manage lower levels.
     */
    private function getAllowedRoles(): array
    {
        $currentUserRole = auth()->user()->roles->first()->name ?? 'customer';
        $currentLevel = self::ROLE_HIERARCHY[$currentUserRole] ?? 999;
        
        // Return roles with lower privilege only
        // Exception: Superadmin can manage ALL including other Superadmins
        $allowedRoles = [];
        foreach (self::ROLE_HIERARCHY as $roleName => $level) {
            if ($currentUserRole === 'superadmin') {
                // Superadmin can manage ALL roles
                $allowedRoles[] = $roleName;
            } else {
                // Others can only manage LOWER roles (not same level)
                if ($level > $currentLevel) {
                    $allowedRoles[] = $roleName;
                }
            }
        }
        
        return $allowedRoles;
    }

    /**
     * Display a listing of users (SUPERADMIN & ADMINISTRATOR only).
     */
    public function index()
    {
        // Check permission
        if (!auth()->user()->can('view users')) {
            abort(403, 'Unauthorized');
        }
        
        // Get current user role level
        $currentUserRole = auth()->user()->roles->first()->name ?? 'customer';
        $currentLevel = self::ROLE_HIERARCHY[$currentUserRole] ?? 999;
        
        // Filter users based on role hierarchy
        if ($currentUserRole === 'superadmin') {
            // Superadmin sees ALL users
            $users = User::with('roles')->latest()->paginate(15);
            $roles = Role::all();
        } else {
            // Other roles only see users with LOWER privilege (not same level)
            $allowedRoles = $this->getAllowedRoles();
            
            if (empty($allowedRoles)) {
                // If no allowed roles, show empty list
                $users = User::with('roles')->whereRaw('1 = 0')->paginate(15);
            } else {
                $users = User::with('roles')
                    ->whereHas('roles', function($query) use ($allowedRoles) {
                        $query->whereIn('name', $allowedRoles);
                    })
                    ->latest()
                    ->paginate(15);
            }
            
            // For dropdown, show only roles that can be managed (lower roles)
            $roles = Role::whereIn('name', $allowedRoles)->get();
        }

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Display contractor users for ADMIN KONTRAKTOR.
     */
    public function contractorIndex()
    {
        // Check permission - only admin_kontraktor
        if (!auth()->user()->hasRole('admin_kontraktor')) {
            abort(403, 'Unauthorized');
        }
        
        // Show only customers and user_kontraktor
        $users = User::with('roles')
            ->whereHas('roles', function($query) {
                $query->whereIn('name', ['customer', 'user_kontraktor']);
            })
            ->paginate(10);
            
        $roles = Role::whereIn('name', ['customer', 'user_kontraktor'])->get();
        
        // Reuse main user management view with scoped data
        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Store a new user (SUPERADMIN & ADMINISTRATOR)
     */
    public function store(Request $request)
    {
        // Check permission
        if (!auth()->user()->can('create users')) {
            abort(403, 'Unauthorized');
        }

        // Get allowed roles based on hierarchy (can only create lower roles)
        $allowedRoles = $this->getAllowedRoles();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in($allowedRoles)],
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
     * Store contractor user (ADMIN KONTRAKTOR only)
     */
    public function contractorStore(Request $request)
    {
        // Check permission - only admin_kontraktor can create customer & user_kontraktor
        if (!auth()->user()->hasRole('admin_kontraktor')) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'in:customer,user_kontraktor'], // Limited roles
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
            ->route('contractor.users.index')
            ->with('success', '✅ ' . ucfirst($validated['role']) . ' berhasil ditambahkan! Welcome ' . $user->name . '! Password: ' . $password);
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        // Check if current user can manage target user
        if (!$this->canManageUser($user)) {
            abort(403, 'Anda tidak dapat mengedit user dengan role yang sama atau lebih tinggi dari Anda!');
        }

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

        // Check if current user can manage target user
        if (!$this->canManageUser($user)) {
            return redirect()
                ->route('users.index')
                ->with('error', '❌ Anda tidak dapat menghapus user dengan role yang sama atau lebih tinggi dari Anda!');
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
        // Check if current user can manage target user
        if (!$this->canManageUser($user)) {
            return redirect()
                ->route('users.index')
                ->with('error', '❌ Anda tidak dapat mengubah status user dengan role yang sama atau lebih tinggi dari Anda!');
        }

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
        // Check if current user can manage target user
        if (!$this->canManageUser($user)) {
            return redirect()
                ->route('users.index')
                ->with('error', '❌ Anda tidak dapat reset password user dengan role yang sama atau lebih tinggi dari Anda!');
        }

        $newPassword = Str::random(12);
        $user->update(['password' => Hash::make($newPassword)]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Password berhasil direset! Password baru: ' . $newPassword);
    }
}
