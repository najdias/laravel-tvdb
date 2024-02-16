<?php

declare(strict_types=1);

namespace Days85\Tvdb\Traits;

use Days85\Tvdb\ApiClient;

trait HasApiClient
{
    protected function client(): ApiClient
    {
        return new ApiClient();
    }
}
