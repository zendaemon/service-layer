<?php

namespace Zendaemon\Services\Traits;

use Illuminate\Database\Eloquent\Model;

trait DestroyModel
{
    public function destroy(Model $model): bool
    {
        try {
            $model->delete();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}