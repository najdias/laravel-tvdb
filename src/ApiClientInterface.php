<?php
declare(strict_types=1);

namespace Days85\Tvdb;

use Days85\Tvdb\Resources\Authentication;
use Days85\Tvdb\Resources\Search;
use Days85\Tvdb\Resources\Series;
use GuzzleHttp\Psr7\Response;

interface ApiClientInterface
{
    public function setToken(string $token = null): void;

    public function authentication(): Authentication;

    public function search(): Search;

    public function series(): Series;

    public function requestHeaders(string $method, string $path, array $options = []): array;

    public function performAPICall(string $method, string $path, array $options = []): Response;

    public function performAPICallWithJsonResponse(string $method, string $path, array $options = []);
}
