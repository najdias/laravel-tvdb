<?php
declare(strict_types=1);

namespace Days85\Tvdb;

use Days85\Tvdb\Resources\Series;

class Tvdb
{
    use Traits\HasApiClient;

    public function search(string $searchQuery, array $optionalParameters = []): array
    {
        return $this
            ->client()
            ->authentication()
            ->login()
            ->search()
            ->search($searchQuery, $optionalParameters);
    }

    public function series(): Series
    {
        return $this
            ->client()
            ->authentication()
            ->login()
            ->series();
    }
}
