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
            ]);
        }
    }

    public function register()
    {
        //
    }
}
