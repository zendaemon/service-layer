<?php

namespace Zendaemon\Services\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the service layer resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->registerServiceLayerServiceProvider();

        $this->info('Service Layer scaffolding installed successfully.');
    }

    /**
     * Register the ServiceLayer service provider in the application configuration file.
     *
     * @throws \Exception
     *
     * @return void
     */
    protected function registerServiceLayerServiceProvider()
    {
        $namespace = Str::replaceLast('\\', '', $this->laravel->getNamespace());

        $appConfig = file_get_contents(config_path('app.php'));

        if (Str::contains($appConfig, $namespace.'\\Providers\\ServiceLayerServiceProvider::class')) {
            return;
        }

        if (!file_exists(app_path('Providers/ServiceLayerServiceProvider.php'))) {
            throw new \Exception('ServiceLayerServiceProvider not published.');
        }

        file_put_contents(app_path('Providers/ServiceLayerServiceProvider.php'), str_replace(
            "namespace App\Providers;",
            "namespace {$namespace}\Providers;",
            file_get_contents(app_path('Providers/ServiceLayerServiceProvider.php'))
        ));

        file_put_contents(config_path('app.php'), str_replace(
            "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL,
            "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL."        {$namespace}\Providers\ServiceLayerServiceProvider::class,".PHP_EOL,
            $appConfig
        ));
    }
}
