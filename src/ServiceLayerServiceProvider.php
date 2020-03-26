<?php

namespace Zendaemon\Services;

use Illuminate\Support\ServiceProvider;

class ServiceLayerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\ConsoleMakeService::class,
                Console\InstallCommand::class,
            ]);
        }
    }

    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../stubs/ServiceLayerServiceProvider.stub' => app_path('Providers/ServiceLayerServiceProvider.php'),
            ], 'service-layer-provider');
        }
    }
}
