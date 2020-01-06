<?php

namespace Zendaemon\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Zendaemon\Services\Exceptions\ModelNotFoundException;

abstract class Service
{
    const DEFAULT_PER_PAGE_ITEMS = 10;

    /** @var Model */
    protected $model;

    public function __construct()
    {
        $this->setModel();

        if (!$this->model || !class_exists($this->model)) {
            throw new ModelNotFoundException("Model {$this->model} not found.");
        }
    }

    /**
     * Set model class name.
     *
     * @return void
     */
    abstract protected function setModel(): void;

    public function getModel(): Model
    {
        return $this->model;
    }

    public function create(Request $request): Model
    {
        return $this->model::create($request->all());
    }

    public function update(Model $model, Request $request): Model
    {
        $model->update($request->all());

        return $model;
    }

    public function destroy(Model $model): bool
    {
        try {
            $model->delete();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function paginated(int $page = 1): LengthAwarePaginator
    {
        return $this->model::paginate(self::DEFAULT_PER_PAGE_ITEMS);
    }
}
