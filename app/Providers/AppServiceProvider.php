<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFive();
        Auth::user()?->loadMissing('role.permissions');
        Gate::before(function ($user, $ability) {
            return $user->hasPermission($ability) ? true : null;
        });
    }
}
