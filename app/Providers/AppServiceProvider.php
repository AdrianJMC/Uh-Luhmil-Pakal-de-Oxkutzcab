<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\URL;


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
        if (env('APP_ENV') !== 'local' && isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            URL::forceScheme('https');
        }

        // Forzar el registro si Laravel no lo reconoce
        Route::aliasMiddleware('role', RoleMiddleware::class);

        Blade::component('components.info-card', 'info-card');

        // Registrar helper global Blade
        Blade::directive('assetAuto', function ($expression) {
            return "<?php echo app()->environment('production') ? secure_asset($expression) : asset($expression); ?>";
        });
    }
}
