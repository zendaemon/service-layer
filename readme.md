## Laravel Service layer
[![License](https://poser.pugx.org/zendaemon/service-layer/license)](https://packagist.org/packages/zendaemon/service-layer)
[![Build Status](https://scrutinizer-ci.com/g/zendaemon/service-layer/badges/build.png?b=master)](https://scrutinizer-ci.com/g/zendaemon/service-layer/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/zendaemon/service-layer/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/zendaemon/service-layer/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/zendaemon/service-layer/v/stable)](https://packagist.org/packages/zendaemon/service-layer)
[![Total Downloads](https://poser.pugx.org/zendaemon/service-layer/downloads)](https://packagist.org/packages/zendaemon/service-layer)
[![StyleCI](https://github.styleci.io/repos/231975607/shield?branch=master)](https://github.styleci.io/repos/231975607)

This Laravel package provides support for simple service layer.
Service class the best place for your business logic.
## Installation

Require this package with composer.

```shell
composer require zendaemon/service-layer
```

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

```php
Zendaemon\Services\ServiceLayerServiceProvider::class,
```

After installing ServiceLayer, publish its assets using the services:install Artisan command:

php artisan services:install

## Usage

###Simple service
Using the make:service Artisan command, you can quickly create such a base service:
```shell
php artisan make:service SomeService
```

### Static service
Or you can create static service for simple tasks:
```shell
php artisan make:service SomeService --static
```

### Resource service
Also you can create service for resource controller:
```shell
php artisan make:service SomeService --resource
```

This command will generate a service at app/Services/SomeService.php. 
The service will contain a trait with some methods for each of the available resource operations.

Next, you may set a model to the service:
```php
    /**
     * Set model class name.
     *
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = SomeModel::class;
    }
```

You can now add SomeService in your controller through DI:
```php
final class SomeController extends Controller
{
    /** @var SomeService $service */
    private $service;

    public function __construct(SomeService $service)
    {
        $this->service = $service;
    }

    public function index(): ?ResourceCollection
    {
        return SomeCollection::collection($this->service->paginated());
    }

    public function store(StoreSomeRequest $request): ?JsonResource
    {
        return SomeResource::make($this->service->create($request));
    }

    public function update(UpdateSomeRequest $request, SomeModel $model): ?JsonResource
    {
        return SomeResource::make($this->service->update($request, $model));
    }

    public function destroy(SomeModel $model): JsonResponse
    {
        if (! $this->service->destroy($model)) {
            return response()->json([
                'message' => 'Some error.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);        
        }

        return response()->json(['success' => Response::HTTP_OK]);
    }
}
```

### Service class binding
You can bind your services in Providers/ServiceLayerServiceProvider class like so.
```php
namespace App\Providers;

use App\Services\LocationService;
use Illuminate\Support\ServiceProvider;

class ServiceLayerServiceProvider extends ServiceProvider
{
    /**
         * Register any application services.
         *
         * @return void
         */
        public function register()
        {
            $this->app->singleton(LocationService::class, function () {
                return new LocationService;
            });
        }
}
```