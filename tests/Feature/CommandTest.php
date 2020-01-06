<?php

namespace Zendaemon\Services\Tests\Feature;

use Illuminate\Support\Facades\File;
use Zendaemon\Services\Tests\TestCase;

class CommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (File::exists(app_path('Services/'))) {
            File::deleteDirectory(app_path('Services/'));
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        if (File::exists(app_path('Services/'))) {
            File::deleteDirectory(app_path('Services/'));
        }
    }

    public function testMakeSimpleServiceCommand(): void
    {
        $this->artisan('make:service', [
            'name' => 'TestService',
        ]);

        $this->assertFileExists(app_path('Services/TestService.php'));
    }

    public function testMakeResourceServiceCommand(): void
    {
        $this->artisan('make:service', [
            'name'       => 'TestResourceService',
            '--resource' => true,
        ]);

        $this->assertFileExists(app_path('Services/TestResourceService.php'));
    }
}
