<?php

namespace Zendaemon\Services\Tests\Feature;

use Illuminate\Support\Facades\File;
use Zendaemon\Services\Tests\TestCase;

class CommandTest extends TestCase
{
    private function clearFiles()
    {
        if (File::exists(app_path('Services'))) {
            File::deleteDirectory(app_path('Services'));
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->clearFiles();
    }

    protected function tearDown(): void
    {
        $this->clearFiles();

        parent::tearDown();
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

    public function testMakeStaticServiceCommand(): void
    {
        $this->artisan('make:service', [
            'name'     => 'TestStaticService',
            '--static' => true,
        ]);

        $this->assertFileExists(app_path('Services/TestStaticService.php'));
    }
}
