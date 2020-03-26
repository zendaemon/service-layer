<?php

namespace Zendaemon\Services\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait ReadModel
{
    public function paginated(int $page = 1): LengthAwarePaginator
    {
        return $this->model::paginate(static::DEFAULT_PER_PAGE_ITEMS);
    }
}