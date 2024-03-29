<?php

declare(strict_types=1);

namespace Days85\Tvdb;

use Days85\Tvdb\Models\SearchResult;
use Days85\Tvdb\Resources\Seasons;
use Days85\Tvdb\Resources\Series;

class Tvdb
{
    use Traits\HasApiClient;

    /**
     * @return SearchResult[]
     */
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

    public function seasons(): Seasons
    {
        return $this
            ->client()
            ->authentication()
            ->login()
            ->seasons();
    }
}
