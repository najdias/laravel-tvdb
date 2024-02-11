<?php

use Days85\Tvdb\ApiClient;
use Days85\Tvdb\Tests\TestCase;
use Days85\Tvdb\Tvdb;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;

uses(
    TestCase::class,
)->in(__DIR__);

function mockApiClient(): MockInterface|LegacyMockInterface|ApiClient
{
    return Mockery::mock(ApiClient::class);
}

function setApiClientMockLoginData(
    ?string $apiKey = 'FOO',
    ?string $expectedToken = 'bar',
    MockInterface|LegacyMockInterface|ApiClient $apiClientMock = null,
): MockInterface|LegacyMockInterface|ApiClient {
    if (!$apiClientMock) {
        $apiClientMock = mockApiClient();
    }

    return $apiClientMock
        ->shouldReceive('performAPICallWithJsonResponse')
        ->once()
        ->with(
            'post',
            'login',
            ['body' => json_encode(['apikey' => $apiKey]), 'http_errors' => true]
        )
        ->andReturn(['token' => $expectedToken])
        ->getMock()
        ->shouldReceive('setToken')
        ->once()
        ->with($expectedToken)
        ->getMock();
}
