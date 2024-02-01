<?php

namespace Viserlab\BackOffice\Facade;

use Viserlab\BackOffice\Facade\Facade;

class Session extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'session';
    }
}