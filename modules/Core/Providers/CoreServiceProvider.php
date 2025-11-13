<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register services
     */
    public function register(): void
    {
        // Register module bindings here
    }

    /**
     * Bootstrap services
     */
    public function boot(): void
    {
        $this->loadRoutes();
    }

    /**
     * Load module routes
     */
    protected function loadRoutes(): void
    {
        $routePath = __DIR__ . '/../Routes/api.php';

        if (file_exists($routePath)) {
            $this->loadRoutesFrom($routePath);
        }
    }
}
