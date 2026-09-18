<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Driver;
use App\Models\Order;
use App\Policies\CustomerPolicy;
use App\Policies\DriverPolicy;
use App\Policies\OrderPolicy;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        app()->setLocale('ar');

        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(Customer::class, CustomerPolicy::class);
        Gate::policy(Driver::class, DriverPolicy::class);

        Gate::define('manage-users', fn ($user) => $user->hasAnyRole(['Admin', 'Manager']));
        Gate::define('manage-settings', fn ($user) => $user->hasAnyRole(['Admin', 'Manager']));
        Gate::define('manage-finances', fn ($user) => $user->hasAnyRole(['Admin', 'Manager']));
        Gate::define('assign-orders', fn ($user) => $user->hasAnyRole(['Admin', 'Manager', 'Employee']));
        Gate::define('view-dashboard', fn ($user) => $user->hasAnyRole(['Admin', 'Manager']));
        Gate::define('view-operational-search', fn ($user) => $user->hasAnyRole(['Admin', 'Manager']));

        RateLimiter::for('api', fn ($request) => Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()));

        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->hasRole('Admin');
        });
    }
}
