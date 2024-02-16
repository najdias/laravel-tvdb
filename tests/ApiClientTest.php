<?php

use Days85\Tvdb\ApiClient;
use Days85\Tvdb\Exceptions\ParseException;
use Days85\Tvdb\Exceptions\ResourceNotFoundException;
use Days85\Tvdb\Exceptions\UnauthorizedException;
use Days85\Tvdb\Resources\Authentication;
use Days85\Tvdb\Resources\Search;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

//beforeEach(function () {
//    config()->set('tvdb.username', 'username');
//    config()->set('tvdb.userkey', 'userkey');
//    config()->set('tvdb.apikey', 'apikey');
//
//    $httpClientMock = Mockery::mock(Client::class);
//
//    $this->apiClient = new Days85\Tvdb\ApiClient($httpClientMock);
//});

function createClientWithMockHandler(array $queue): Client
{
    $mock = new MockHandler($queue);

    return new Client(['handler' => HandlerStack::create($mock)]);
}

function createTokenErrorClient(): Client
{
    return createClientWithMockHandler([
        new Response(401, ['Content-Length' => 0]),
        new RequestException('Error Communicating with Server', new Request('GET', 'test')),
    ]);
}

function createPathErrorClient(): Client
{
    return createClientWithMockHandler([
        new Response(404, ['Content-Length' => 0]),
        new RequestException('Error Communicating with Server', new Request('GET', 'test')),
    ]);
}

test('resource instance types', function () {
    $client = new ApiClient();

    $this->assertInstanceOf(Authentication::class, $client->authentication());
    $this->assertInstanceOf(Search::class, $client->search());
});

test('if headers are returned', function () {
    $expectedHeaders = ['X-foo' => ['Bar']];
    $mock = new MockHandler([
        new Response(200, $expectedHeaders),
        new RequestException('Error Communicating with Server', new Request('GET', 'test')),
    ]);

    $handler = HandlerStack::create($mock);
    $client = new Client(['handler' => $handler]);
    $testInstance = new ApiClient($client);

    $headers = $testInstance->requestHeaders('GET', '/');
    $this->assertEquals($expectedHeaders, $headers);
});

test('request with missing token', function () {
    $client = createTokenErrorClient();
    $testInstance = new ApiClient($client);

    $this->expectException(UnauthorizedException::class);
    $testInstance->requestHeaders('GET', 'fail');
});

test('request headers path error', function () {
    $client = createPathErrorClient();
    $testInstance = new ApiClient($client);

    $this->expectException(ResourceNotFoundException::class);
    $testInstance->requestHeaders('GET', 'fail');
});

test('api call json error', function () {
    $client = createClientWithMockHandler([
        new Response(201, []),
        new RequestException('Error Communicating with Server', new Request('GET', 'test')),
    ]);
    $testInstance = new ApiClient($client);

    $this->expectException(Exception::class);
    $testInstance->performAPICallWithJsonResponse('GET', 'fail');
});

test('api call invalid json', function () {
    $input = 'ABC';
    $client = createClientWithMockHandler([
        new Response(200, [], $input),
        new RequestException('Error Communicating with Server', new Request('GET', 'test')),
    ]);
    $testInstance = new ApiClient($client);

    $this->expectException(ParseException::class);
    $testInstance->performAPICallWithJsonResponse('GET', '/');
});

test('api call with invalid formed response', function () {
    $input = "{'a:'hello'}";
    $client = createClientWithMockHandler([
        new Response(200, [], $input),
        new RequestException('Error Communicating with Server', new Request('GET', 'test')),
    ]);
    $testInstance = new ApiClient($client);

    $this->expectException(ParseException::class);
    $testInstance->performAPICallWithJsonResponse('GET', '/');
});

test('api call with errors', function () {
    $expected = [
        'foo' => 'bar',
        'errors' => [
            'invalidLanguage' => 'not found',
            'invalidQueryParams' => 'invalid param a',
            'invalidFilters' => 'invalid filter b',
        ],
    ];
    $client = createClientWithMockHandler([
        new Response(200, [], json_encode($expected)),
        new RequestException('Error Communicating with Server', new Request('GET', 'test')),
    ]);
    $testInstance = new ApiClient($client);

    $result = $testInstance->performAPICallWithJsonResponse('GET', '/');
    $this->assertEquals($expected, $result);
});

test('api call returning json', function () {
    $expected = ['foo' => 'bar', 'baz' => 'foobar'];

    $client = createClientWithMockHandler([
        new Response(200, [], json_encode($expected)),
        new RequestException('Error Communicating with Server', new Request('GET', 'test')),
    ]);
    $testInstance = new ApiClient($client);

    $result = $testInstance->performAPICallWithJsonResponse('GET', '/');
    $this->assertEquals($expected, $result);
});

test('api call return data json', function () {
    $expected = ['foo' => 'bar', 'data' => ['barfoo' => 'foobar']];
    $client = createClientWithMockHandler([
        new Response(200, [], json_encode($expected)),
        new RequestException('Error Communicating with Server', new Request('GET', 'test')),
    ]);
    $testInstance = new ApiClient($client);

    $result = $testInstance->performAPICallWithJsonResponse('GET', '/');
    $this->assertEquals($expected['data'], $result);
});
