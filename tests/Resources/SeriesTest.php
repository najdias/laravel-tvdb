<?php

use Days85\Tvdb\ApiClientInterface;
use Days85\Tvdb\Enums\SeasonType;
use Days85\Tvdb\Resources\Series;

it('gets simple series', function () {
    $seriesId = 73762;
    $json = file_get_contents(__DIR__.'/../Data/series_simple.json');
    $return = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

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
});

it('gets episodes without language', function () {
    $seriesId = 73762;
    $page = 0;
    $season = 1;
    $options = ['query' => ['page' => $page, 'season' => $season]];
    $json = file_get_contents(__DIR__.'/../Data/series_episodes_no_lang.json');
    $return = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

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

    $this->assertNotNull($episodes);
    $this->assertIsArray($episodes);
});

it('gets episodes with language', function () {
    $seriesId = 73762;
    $page = 0;
    $season = 1;
    $language = 'eng';
    $options = ['query' => ['page' => $page]];
    $json = file_get_contents(__DIR__.'/../Data/series_episodes_lang.json');
    $return = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

    /** @var ApiClientInterface $clientMock */
    $clientMock = mockApiClient()
        ->shouldReceive('performAPICallWithJsonResponse')
        ->once()
        ->with(
            'get',
            'series/'.$seriesId.'/episodes/default/'.$language,
            $options,
        )
        ->andReturn($return)
        ->getMock();
    $series = new Series($clientMock);
    $episodes = $series->episodes(
        $seriesId,
        $season,
        $page,
        SeasonType::DEFAULT,
        $language,
    );

    $this->assertIsArray($episodes);
});

it('gets episodes with different season type than default', function () {
    $seriesId = 1337;
    $page = 0;
    $season = 1;
    $options = ['query' => ['page' => $page, 'season' => $season]];
    $json = file_get_contents(__DIR__.'/../Data/series_episodes_no_lang.json');
    $return = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

    /** @var ApiClientInterface $clientMock */
    $clientMock = mockApiClient()
        ->shouldReceive('performAPICallWithJsonResponse')
        ->once()
        ->with(
            'get',
            'series/'.$seriesId.'/episodes/official',
            $options,
        )
        ->andReturn($return)
        ->getMock();
    $series = new Series($clientMock);
    $episodes = $series->episodes($seriesId, $season, $page, SeasonType::OFFICIAL);

    $this->assertIsArray($episodes);
});

it('gets extended series', function () {
    $seriesId = 1337;
    $json = file_get_contents(__DIR__.'/../Data/series_extended.json');
    $return = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

    /** @var ApiClientInterface $clientMock */
    $clientMock = mockApiClient()
        ->shouldReceive('performAPICallWithJsonResponse')
        ->once()
        ->with(
            'get',
            'series/'.$seriesId.'/extended',
        )
        ->andReturn($return)
        ->getMock();
    $series = new Series($clientMock);
    $result = $series->extended($seriesId);
    $this->assertNotNull($result->id);
    $this->assertNotNull($result->slug);
    $this->assertNotNull($result->name);
});
