<?php

namespace Zendaemon\Services;

use Illuminate\Support\ServiceProvider;

class ServiceLayerGeneratorServiceProvider extends ServiceProvider
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
                __DIR__.'/../stubs/ServiceLayerGeneratorServiceProvider.stub' => app_path('Providers/ServiceLayerGeneratorServiceProvider.php'),
            ], 'service-layer-generator-provider');
        }
    }
}
