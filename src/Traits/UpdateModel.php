<?php

namespace Zendaemon\Services\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait UpdateModel
{
    public function update(Model $model, Request $request): Model
    {
        $model->update($request->all());

        return $model;
    }
}
