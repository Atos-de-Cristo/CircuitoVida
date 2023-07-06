<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
        Carbon::setLocale('pt_BR');
        Permission::observe(Permission::class);
        Gate::before(function (User $user, $ability) {
            if (Permission::existsOnCache($ability)) {
                return $user->hasPermissionTo($ability);
            }
        });
    }
}
