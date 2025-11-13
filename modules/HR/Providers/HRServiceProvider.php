<?php

namespace Modules\HR\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\HR\Repositories\DivisionRepository;
use Modules\HR\Services\DivisionService;

class HRServiceProvider extends ServiceProvider
{
    /**
     * Register services
     */
    public function register(): void
    {
        // Register repository bindings
        $this->app->bind(DivisionRepository::class, function ($app) {
            return new DivisionRepository(new \Modules\HR\Models\Division());
        });

        // Register service bindings
        $this->app->bind(DivisionService::class, function ($app) {
            return new DivisionService($app->make(DivisionRepository::class));
        });
    }

    /**
     * Bootstrap services
     */
    public function boot(): void
    {
        $this->loadMigrations();
        $this->loadRoutes();
    }

    /**
     * Load module migrations
     */
    protected function loadMigrations(): void
    {
        $migrationPath = __DIR__ . '/../Database/Migrations';

        if (is_dir($migrationPath)) {
            $this->loadMigrationsFrom($migrationPath);
        }
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
