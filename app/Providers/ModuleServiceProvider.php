<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services
     */
    public function register(): void
    {
        $this->registerModules();
    }

    /**
     * Bootstrap services
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register all active modules
     */
    protected function registerModules(): void
    {
        $modules = config('modules.modules', []);
        $namespace = config('modules.namespace', 'Modules');

        foreach ($modules as $module) {
            $providerClass = "{$namespace}\\{$module}\\Providers\\{$module}ServiceProvider";

            if (class_exists($providerClass)) {
                $this->app->register($providerClass);
            }
        }
    }
}
