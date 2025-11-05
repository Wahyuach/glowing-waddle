<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
class AuthServiceProvider extends ServiceProvider
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
      //Gate  mitra (buat menu admin)
        Gate::define('is-mitra', function (User $user) {
            return $user->isMitra(); 
        });

        //Gate Investor (buat menu 'Ternak Saya')
        Gate::define('is-admin', function (User $user) {
            return $user->isAdmin(); 
        });
    }
}
