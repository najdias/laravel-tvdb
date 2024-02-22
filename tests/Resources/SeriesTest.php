<?php

use Days85\Tvdb\ApiClientInterface;
use Days85\Tvdb\Resources\Series;

it('gets simple series', function () {
    $seriesId = 1337;
    $slug = 'foo-bar-baz';
    $name = 'foo bar baz';
    $return = [
        'id' => $seriesId,
        'slug' => $slug,
        'name' => $name,
    ];

    /** @var ApiClientInterface $clientMock */
    $clientMock = mockApiClient()
        ->shouldReceive('performAPICallWithJsonResponse')
        ->once()
        ->with(
            'get',
            'series/'.$seriesId,
        )
        ->andReturn($return)
        ->getMock();
    $series = new Series($clientMock);
    $result = $series->simple($seriesId);
    $this->assertEquals($seriesId, $result->id);
    $this->assertEquals($slug, $result->slug);
    $this->assertEquals($name, $result->name);
});

it('gets episodes without language', function () {
    $seriesId = 1337;
    $page = 1;
    $season = 0;
    $options = ['query' => ['page' => $page, 'season' => $season]];
    $return = [
        [
            'id' => '123',
            'name' => 'foo bar',
        ],
        [
            'id' => '124',
            'name' => 'bar baz',
        ],
    ];

    /** @var ApiClientInterface $clientMock */
    $clientMock = mockApiClient()
        ->shouldReceive('performAPICallWithJsonResponse')
        ->once()
        ->with(
            'get',
            'series/'.$seriesId.'/episodes/default',
            $options,
        )
        ->andReturn($return)
        ->getMock();
    $series = new Series($clientMock);
    $episodes = $series->episodes($seriesId, $season, $page);

    $this->assertIsArray($episodes);
});

it('gets episodes with language', function () {
    $seriesId = 1337;
    $page = 1;
    $season = 0;
    $language = 'en';
    $options = ['query' => ['page' => $page]];
    $return = [
        [
            'id' => '123',
            'name' => 'foo bar',
        ],
        [
            'id' => '124',
            'name' => 'bar baz',
        ],
    ];

    /** @var ApiClientInterface $clientMock */
    $clientMock = mockApiClient()
        ->shouldReceive('performAPICallWithJsonResponse')
        ->once()
        ->with(
            'get',
            'series/'.$seriesId.'/episodes/default/en',
            $options,
        )
        ->andReturn($return)
        ->getMock();
    $series = new Series($clientMock);
    $episodes = $series->episodes(
        $seriesId,
        $season,
        $page,
        Series::SEASON_TYPE_DEFAULT,
        $language,
    );

    $this->assertIsArray($episodes);
});

it('throws exception with wrong season type on get episodes', function () {
    $seriesId = 1337;
    $page = 1;
    $season = 0;

    /** @var ApiClientInterface $clientMock */
    $clientMock = mockApiClient();
    $series = new Series($clientMock);
    $episodes = $series->episodes($seriesId, $season, $page, 'foo');

    $this->assertIsArray($episodes);
})->expectException(InvalidArgumentException::class);
