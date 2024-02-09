<?php

namespace Days85\Tvdb;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Days85\Tvdb\Commands\TvdbCommand;

class TvdbServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-tvdb')
            ->hasConfigFile();
    }
}
