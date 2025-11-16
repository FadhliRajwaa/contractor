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
        // Gate: Check if agency can add more users based on tier
        Gate::define('agency-can-add-user', function (User $user, Agency $agency) {
            // Only tier 3-5 can have users
            if ($agency->tier < 3 || $agency->tier > 5) {
                return false;
            }

            // Check if agency has reached max users
            return $agency->canAddUser();
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
