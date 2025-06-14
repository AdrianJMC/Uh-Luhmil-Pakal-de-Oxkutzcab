<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

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
        // Registrar middlewares de Spatie
        Route::aliasMiddleware('permission', PermissionMiddleware::class);
        // Forzar el registro si Laravel no lo reconoce
        Route::aliasMiddleware('role', RoleMiddleware::class);

        Blade::component('components.info-card', 'info-card');
    }
}
