<?php

namespace Zendaemon\Services\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait CreateModel
{
    public function create(Request $request): Model
    {
        return $this->model::create($request->all());
    }
}