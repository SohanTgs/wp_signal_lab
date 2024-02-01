<?php

namespace Viserlab\BackOffice\Facade;

use Viserlab\BackOffice\Facade\Facade;

class DB extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'db';
    }
}