<?php

namespace Zendaemon\Services;

use Illuminate\Database\Eloquent\Model;
use Zendaemon\Services\Contracts\ServiceInterface;
use Zendaemon\Services\Exceptions\ModelNotFoundException;

abstract class Service implements ServiceInterface
{
    /** @var Model */
    protected $model;

    /**
     * Service constructor.
     * @throws ModelNotFoundException
     */
    public function __construct()
    {
        $this->setModel();

        if (!$this->model || !class_exists($this->model)) {
            throw new ModelNotFoundException();
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
}
