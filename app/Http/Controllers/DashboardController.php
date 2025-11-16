<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private const ROLE_HIERARCHY = [
        'superadmin' => 1,
        'administrator' => 2,
        'admin_kontraktor' => 3,
        'user_kontraktor' => 4,
        'customer' => 5,
    ];

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

        $currentUser = auth()->user();

        $visibleRoles = $this->getVisibleRolesForDashboard($currentUser);

        $manageableRoles = $this->getManageableRolesForDashboard($currentUser);

        $baseQuery = User::with('roles')
            ->when(!empty($visibleRoles), function ($query) use ($visibleRoles) {
                $query->whereHas('roles', function ($roleQuery) use ($visibleRoles) {
                    $roleQuery->whereIn('name', $visibleRoles);
                });
            });

        $totalUsers = (clone $baseQuery)->count();
        $activeUsers = (clone $baseQuery)->where('is_active', true)->count();
        $inactiveUsers = (clone $baseQuery)->where('is_active', false)->count();
        $recentUsers = (clone $baseQuery)->latest()->take(5)->get();

        $roleCounts = [];
        foreach ($manageableRoles as $roleName) {
            $roleCounts[$roleName] = (clone $baseQuery)
                ->whereHas('roles', function ($query) use ($roleName) {
                    $query->where('name', $roleName);
                })
                ->count();
        }

        $recentUsers = $this->enrichUsersWithLastActive($recentUsers);

        $dashboardData = [
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
            'totalRoles' => empty($visibleRoles)
                ? 0
                : Role::whereIn('name', $visibleRoles)->count(),
            'recentUsers' => $recentUsers,
            'roleCounts' => $roleCounts,
            'dashboardType' => $currentUser?->roles->first()->name ?? null,
        ];

        return view('dashboard.index', compact('dashboardData'));
    }

    /**
     * Determine which roles are visible for dashboard statistics based on hierarchy.
     */
    private function getVisibleRolesForDashboard(?User $user): array
    {
        $currentRole = $user?->roles->first()->name ?? null;

        if (!$currentRole) {
            return [];
        }

        // Superadmin can see all roles
        if ($currentRole === 'superadmin') {
            return array_keys(self::ROLE_HIERARCHY);
        }

        $currentLevel = self::ROLE_HIERARCHY[$currentRole] ?? 999;

        $visibleRoles = [$currentRole];

        foreach (self::ROLE_HIERARCHY as $roleName => $level) {
            if ($level > $currentLevel) {
                $visibleRoles[] = $roleName;
            }
        }

        return $visibleRoles;
    }

    private function getManageableRolesForDashboard(?User $user): array
    {
        $currentRole = $user?->roles->first()->name ?? null;

        if (!$currentRole) {
            return [];
        }

        $currentLevel = self::ROLE_HIERARCHY[$currentRole] ?? 999;

        $manageableRoles = [];

        if ($currentRole === 'superadmin') {
            foreach (self::ROLE_HIERARCHY as $roleName => $level) {
                $manageableRoles[] = $roleName;
            }
        } else {
            foreach (self::ROLE_HIERARCHY as $roleName => $level) {
                if ($level > $currentLevel) {
                    $manageableRoles[] = $roleName;
                }
            }
        }

        return $manageableRoles;
    }

    /**
     * Attach last active time to each user using sessions table.
     */
    private function enrichUsersWithLastActive($users)
    {
        $userIds = $users->pluck('id')->filter()->all();

        if (empty($userIds)) {
            return $users;
        }

        $lastActivities = DB::table('sessions')
            ->select('user_id', DB::raw('MAX(last_activity) as last_activity'))
            ->whereIn('user_id', $userIds)
            ->groupBy('user_id')
            ->pluck('last_activity', 'user_id');

        $users->each(function ($user) use ($lastActivities) {
            $lastActivity = $lastActivities[$user->id] ?? null;
            $user->last_active_at = $lastActivity
                ? Carbon::createFromTimestamp($lastActivity)
                : null;
        });

        return $users;
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
