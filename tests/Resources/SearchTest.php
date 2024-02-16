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
    $return = [
        ['id' => '1', 'name' => 'foo', 'tvdb_id' => 'tt123'],
        ['id' => '2', 'name' => 'bar', 'tvdb_id' => 'tt456'],
    ];
    $options = ['query' => ['query' => $name]];

    $clientMock = setApiClientMockSearchData($return, $options);

    $resource = new Search($clientMock);
    $results = $resource->search($name);
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
