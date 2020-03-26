<?php

namespace Zendaemon\Services\Tests\Extra;

class TestStaticService
{
    public static function getRecords(string $class)
    {
        return $class::paginate();
    }
}
