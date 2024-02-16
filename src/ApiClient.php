<?php
declare(strict_types=1);

namespace Days85\Tvdb;

use Days85\Tvdb\Exceptions\ParseException;
use Days85\Tvdb\Exceptions\ResourceNotFoundException;
use Days85\Tvdb\Exceptions\UnauthorizedException;
use Days85\Tvdb\Models\Links;
use Days85\Tvdb\Resources\Authentication;
use Days85\Tvdb\Resources\ResourceFactory;
use Days85\Tvdb\Resources\Search;
use Days85\Tvdb\Resources\Series;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class ApiClient implements ApiClientInterface
{
    protected const string API_BASE_URI = 'https://api4.thetvdb.com/v4/';

    private ?string $token = null;
    private ?Links $links = null;
    private Client $httpClient;

    public function __construct(Client $client = null)
    {
        if ($client === null) {
            $this->httpClient = new Client(
                [
                    'base_uri' => static::API_BASE_URI,
                    'verify'   => false,
                    'headers'  => ['accept' => 'application/json'],
                ]
            );
        } else {
            $this->httpClient = $client;
        }
    }

    public function setToken(string $token = null): void
    {
        $this->token = $token;
    }

    public function getLinks(): ?Links
    {
        return $this->links;
    }

    public function authentication(): Authentication
    {
        return ResourceFactory::getResourceInstance($this, Authentication::class);
    }

    public function search(): Search
    {
        return ResourceFactory::getResourceInstance($this, Search::class);
    }

    public function series(): Series
    {
        return ResourceFactory::getResourceInstance($this, Series::class);
    }

    public function requestHeaders(string $method, string $path, array $options = []): array
    {
        $options = $this->getDefaultHttpClientOptions($options);

        /* @type Response $response */
        $response = $this->httpClient->{$method}($path, $options);

        if ($response->getStatusCode() === 401) {
            throw UnauthorizedException::invalidToken();
        }

        if ($response->getStatusCode() === 404) {
            throw ResourceNotFoundException::notFound($path, $options);
        }

        return $response->getHeaders();
    }

    private function getDefaultHttpClientOptions(array $options = []): array
    {
        $headers = [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if ($this->token) {
            $headers['Authorization'] = 'Bearer '.$this->token;
        }

        $options['http_errors'] = false;

        return array_merge_recursive(['headers' => $headers], $options);
    }

    public function performAPICall(string $method, string $path, array $options = []): Response
    {
        $options = $this->getDefaultHttpClientOptions($options);

        /* @type Response $response */
        $response = $this->httpClient->{$method}($path, $options);

        if ($response->getStatusCode() === 401) {
            throw UnauthorizedException::invalidToken();
        }

        if ($response->getStatusCode() === 404) {
            throw ResourceNotFoundException::notFound($path, $options);
        }

        return $response;
    }

    public function performAPICallWithJsonResponse(string $method, string $path, array $options = [])
    {
        $response = $this->performAPICall($method, $path, $options);

        if ($response->getStatusCode() === 200) {
            $contents = $response->getBody()->getContents();
            $json = json_decode($contents, true);
            if ($json === null) {
                throw ParseException::decode();
            }

            $this->links = null;
            if (array_key_exists('links', $json)) {
                $this->links = DataParser::parseData($json['links'], Links::class);
            }

            if (array_key_exists('data', $json) === false) {
                return $json;
            }
            return $json['data'];
        }

        throw new Exception(
            sprintf(
                'Got status code %d from service at path %s',
                $response->getStatusCode(),
                $path
            )
        );
    }
}
