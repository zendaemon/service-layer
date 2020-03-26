<?php

namespace Zendaemon\Services\Tests\Feature;

use Illuminate\Http\Request;
use Zendaemon\Services\Service;
use Zendaemon\Services\Tests\Extra\TestModel;
use Zendaemon\Services\Tests\TestCase;
use Zendaemon\Services\Traits\CreateModel;
use Zendaemon\Services\Traits\DestroyModel;
use Zendaemon\Services\Traits\ReadModel;
use Zendaemon\Services\Traits\UpdateModel;

class ResourceServiceTest extends TestCase
{
    private $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new class() extends Service {
            use CreateModel;
            use ReadModel;
            use UpdateModel;
            use DestroyModel;

            protected function setModel(): void
            {
                $this->model = TestModel::class;
            }
        };
    }

    public function testServiceStoreModel(): void
    {
        $request = new Request(TestModel::factory());
        $model = $this->service->create($request);

        $this->assertInstanceOf(TestModel::class, $model);
        $this->assertDatabaseHas((new TestModel())->getTable(), [
            'name' => $request->input('name'),
        ]);
    }

    public function testServiceUpdateModel(): void
    {
        $model = TestModel::create(TestModel::factory());
        $request = new Request(TestModel::factory());
        $updatedModel = $this->service->update($model, $request);

        $this->assertInstanceOf(TestModel::class, $updatedModel);
        $this->assertDatabaseHas((new TestModel())->getTable(), [
            'name' => $request->input('name'),
        ]);
    }

    public function testServiceDestroyModel(): void
    {
        $model = TestModel::create(TestModel::factory());
        $this->service->destroy($model);

        $this->assertDatabaseMissing((new TestModel())->getTable(), [
            'name' => $model->name,
        ]);
    }

    public function testServicePaginatedModels(): void
    {
        $count = $counter = 10;
        do {
            TestModel::create(TestModel::factory());

            $counter--;
        } while ($counter);

        $collection = $this->service->paginated();
        $this->assertCount($count, $collection->items());
    }
}
