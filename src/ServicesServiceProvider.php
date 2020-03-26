<?php

namespace Zendaemon\Services;

use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
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
        //
    }
}
