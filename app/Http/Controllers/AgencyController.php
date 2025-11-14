<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    /**
     * List semua agency (hanya untuk admin_kontraktor).
     */
    public function index()
    {
        // Gate by permission/role
        if (!auth()->user()->hasRole('admin_kontraktor')) {
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
}
