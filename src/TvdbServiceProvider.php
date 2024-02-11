<?php
declare(strict_types = 1);

namespace Days85\Tvdb;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TvdbServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-tvdb')
            ->hasConfigFile();
    }
}
