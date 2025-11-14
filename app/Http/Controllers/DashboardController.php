<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with role-based content.
     */
    public function index()
    {
        // Debug authentication status
        \Log::info('Dashboard accessed', [
            'authenticated' => \Auth::check(),
            'user_id' => \Auth::id(),
            'user_email' => \Auth::user()?->email ?? 'N/A',
            'session_id' => request()->session()->getId(),
        ]);

        $user = auth()->user();
        $dashboardData = [];

        // SUPERADMIN: System-wide overview
        if ($user->hasRole('superadmin')) {
            $dashboardData = [
                'totalUsers' => User::count(),
                'totalRoles' => Role::count(),
                'activeUsers' => User::where('is_active', true)->count(),
                'recentUsers' => User::with('roles')->latest()->take(5)->get(),
                'dashboardType' => 'superadmin'
            ];
        }
        // ADMINISTRATOR: System administration
        elseif ($user->hasRole('administrator')) {
            $dashboardData = [
                'totalUsers' => User::count(),
                'activeUsers' => User::where('is_active', true)->count(),
                'recentUsers' => User::with('roles')->latest()->take(5)->get(),
                'dashboardType' => 'administrator'
            ];
        }
        // ADMIN KONTRAKTOR: Contractor management overview
        elseif ($user->hasRole('admin_kontraktor')) {
            $dashboardData = [
                'totalCustomers' => User::role('customer')->count(),
                'totalUserKontraktor' => User::role('user_kontraktor')->count(),
                'totalProjects' => 0, // TODO: Implement when Project model ready
                'activeProjects' => 0, // TODO: Implement when Project model ready
                'recentCustomers' => User::role('customer')->latest()->take(5)->get(),
                'dashboardType' => 'admin_kontraktor'
            ];
        }
        // USER KONTRAKTOR: Limited contractor view
        elseif ($user->hasRole('user_kontraktor')) {
            $dashboardData = [
                'assignedProjects' => 0, // TODO: Implement when Project model ready
                'completedProjects' => 0, // TODO: Implement when Project model ready
                'pendingTasks' => 0, // TODO: Implement when Task model ready
                'dashboardType' => 'user_kontraktor'
            ];
        }
        // CUSTOMER: Customer view
        elseif ($user->hasRole('customer')) {
            $dashboardData = [
                'myProjects' => 0, // TODO: Implement when Project model ready
                'openTickets' => 0, // TODO: Implement when Ticket model ready
                'projectUpdates' => [], // TODO: Implement when Project model ready
                'dashboardType' => 'customer'
            ];
        }

        return view('dashboard.index', compact('dashboardData'));
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
