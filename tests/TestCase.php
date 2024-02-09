<?php

namespace Days85\Tvdb\Tests;

use Days85\Tvdb\TvdbServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            TvdbServiceProvider::class,
        ];
    }
}
