<?php

use Days85\Tvdb\ApiClient;
use Days85\Tvdb\Models\SearchResult;
use Days85\Tvdb\Resources\Search;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;

function setApiClientMockSearchData(
    mixed $return,
    mixed $options,
): MockInterface|LegacyMockInterface|ApiClient {
    return mockApiClient()
        ->shouldReceive('performAPICallWithJsonResponse')
        ->once()
        ->with(
            'get',
            'search',
            $options
        )
        ->andReturn($return)
        ->getMock();
}

it('searches by name', function () {
    $name = 'foo';
    $json = file_get_contents(__DIR__.'/../Data/search.json');
    $return = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    $options = ['query' => ['query' => $name, 'type' => 'series']];
    $optionalParameters = ['type' => 'series'];

    $clientMock = setApiClientMockSearchData($return, $options);

    $resource = new Search($clientMock);
    $results = $resource->search($name, $optionalParameters);
    $this->assertContainsOnlyInstancesOf(SearchResult::class, $results);

    foreach ($results as $key => $result) {
        $this->assertEquals($return[$key]['id'], $result->id);
        $this->assertEquals($return[$key]['name'], $result->name);
        $this->assertEquals($return[$key]['tvdb_id'], $result->tvdb_id);
    }
});

it('throws InvalidArgumentException if optional parameters no in the valid list', function () {
    $name = 'foo';
    $optionalParameters = ['foo' => 'bar'];

    $clientMock = mockApiClient();

    $resource = new Search($clientMock);
    $this->expectException(InvalidArgumentException::class);
    $resource->search($name, $optionalParameters);
});
