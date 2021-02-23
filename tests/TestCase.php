<?php

namespace Zendaemon\Services\Tests;

use Zendaemon\Services\ServiceLayerGeneratorServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceLayerGeneratorServiceProvider::class,
        ];
    }
}
