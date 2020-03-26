<?php

namespace Zendaemon\Services\Tests\Feature;

use Zendaemon\Services\Tests\Extra\TestModel;
use Zendaemon\Services\Tests\Extra\TestStaticService;
use Zendaemon\Services\Tests\TestCase;

class StaticServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testServicePaginatedModels(): void
    {
        $count = $counter = 10;
        do {
            TestModel::create(TestModel::factory());

            $counter--;
        } while ($counter);

        $collection = TestStaticService::getRecords(TestModel::class);
        $this->assertCount($count, $collection->items());
    }
}
