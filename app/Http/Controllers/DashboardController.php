<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        return view('dashboard.index');
    }

    /**
     * Search functionality for dashboard
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        $filter = $request->get('filter', 'all');
        
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $users = User::with('roles')
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhereHas('roles', function($roleQuery) use ($query) {
                      $roleQuery->where('name', 'LIKE', "%{$query}%");
                  });
            });

        // Apply filter
        if ($filter === 'active') {
            $users->where('is_active', true);
        } elseif ($filter === 'inactive') {
            $users->where('is_active', false);
        }

        $results = $users->take(10)->get();

        return response()->json($results->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_active' => $user->is_active,
                'avatar_url' => $user->avatar_url,
                'roles' => $user->roles->pluck('name')
            ];
        }));
    }
}
