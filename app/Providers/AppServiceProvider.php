<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\Agency;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate: Check if agency can add more admin_kontraktor users (max 5)
        Gate::define('agency-can-add-admin-kontraktor', function (User $user, Agency $agency) {
            // Count current admin_kontraktor users in this agency
            $adminKontraktorCount = $agency->users()
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'admin_kontraktor');
                })
                ->count();

            // Max 5 admin_kontraktor per agency
            return $adminKontraktorCount < 5;
        });

        // Gate: Check if user can be assigned to agency
        Gate::define('can-assign-to-agency', function (User $authUser, Agency $agency, ?User $targetUser = null) {
            // Superadmin and Administrator can assign anyone
            if ($authUser->hasAnyRole(['superadmin', 'administrator'])) {
                return true;
            }

            // Admin kontraktor can only assign to their own agency
            if ($authUser->hasRole('admin_kontraktor')) {
                return $authUser->agency_id === $agency->id;
            }

            return false;
        });
    }
}
