<?php

namespace Days85\Tvdb\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Days85\Tvdb\TvdbServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            TvdbServiceProvider::class,
        ];
    }
}
