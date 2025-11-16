<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    /**
     * List semua agency (untuk role yang punya permission view agencies).
     */
    public function index()
    {
        // Gate by permission so superadmin, administrator, dan admin_kontraktor bisa akses
        if (!auth()->user()->can('view agencies')) {
            abort(403, 'Unauthorized');
        }

        $agencies = Agency::orderByDesc('created_at')->paginate(10);

        return view('agencies.index', compact('agencies'));
    }

    /**
     * Store agency baru.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('create agencies')) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'pic_name' => ['nullable', 'string', 'max:255'],
        ]);

        Agency::create($validated);

        return redirect()
            ->route('agencies.index')
            ->with('success', '✅ Agency / Kontraktor baru berhasil ditambahkan.');
    }

    /**
     * Update agency.
     */
    public function update(Request $request, Agency $agency)
    {
        if (!auth()->user()->can('edit agencies')) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'pic_name' => ['nullable', 'string', 'max:255'],
        ]);

        $agency->update($validated);

        return redirect()
            ->route('agencies.index')
            ->with('success', '🔄 Data agency berhasil diperbarui.');
    }

    /**
     * Hapus agency.
     */
    public function destroy(Agency $agency)
    {
        if (!auth()->user()->can('delete agencies')) {
            abort(403, 'Unauthorized');
        }

        $agency->delete();

        return redirect()
            ->route('agencies.index')
            ->with('success', '🗑️ Agency berhasil dihapus.');
    }

    public function toggleStatus(Agency $agency)
    {
        try {
            $agency->is_active = !$agency->is_active;
            $agency->save();

            $status = $agency->is_active ? 'diaktifkan' : 'dinonaktifkan';

            return response()->json([
                'success' => true,
                'message' => "Agency berhasil {$status}.",
                'is_active' => $agency->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah status agency.'
            ], 500);
        }
    }
}
