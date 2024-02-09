<?php

namespace Days85\Tvdb\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Days85\Tvdb\Tvdb
 */
class Tvdb extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Days85\Tvdb\Tvdb::class;
    }
}
