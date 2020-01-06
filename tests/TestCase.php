<?php

namespace Zendaemon\Services\Tests;

use Zendaemon\Services\ServicesServiceProvider;
use Zendaemon\Services\Tests\Extra\TestModel;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function setUpDatabase()
    {
        TestModel::migrate();
    }

    protected function getPackageProviders($app)
    {
        return [
            ServicesServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
