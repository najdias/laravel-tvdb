<?php
declare(strict_types=1);

namespace Days85\Tvdb;

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
}
