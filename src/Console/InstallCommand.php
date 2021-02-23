<?php

namespace Zendaemon\Services\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    private const PROVIDER_NAME = 'ServiceLayerServiceProvider';

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
     * @throws \Exception
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

        if (Str::contains($appConfig, $namespace.'\\Providers\\'.self::PROVIDER_NAME.'::class')) {
            return;
        }

        if (!file_exists(app_path('Providers/'.self::PROVIDER_NAME.'.php'))) {
            throw new \Exception(self::PROVIDER_NAME.' not published.');
        }

        file_put_contents(app_path('Providers/'.self::PROVIDER_NAME.'.php'), str_replace(
            "namespace App\Providers;",
            "namespace {$namespace}\Providers;",
            file_get_contents(app_path('Providers/'.self::PROVIDER_NAME.'.php'))
        ));

        file_put_contents(config_path('app.php'), str_replace(
            "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL,
            "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL."        {$namespace}\Providers\\".self::PROVIDER_NAME."::class,".PHP_EOL,
            $appConfig
        ));
    }
}
