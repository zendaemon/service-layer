<?php

namespace Zendaemon\Services\Exceptions;

use Exception;

class ModelNotFoundException extends Exception
{
    protected $message = "Model not found.";
}
