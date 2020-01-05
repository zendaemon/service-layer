<?php

namespace Zendaemon\Services\Tests;

use Zendaemon\Services\ServicesServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ServicesServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // $app['config']->set('');
    }
}
