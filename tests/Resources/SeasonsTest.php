<?php

declare(strict_types=1);

use Days85\Tvdb\ApiClientInterface;
use Days85\Tvdb\Resources\Seasons;

it('gets extended season', function () {
    $seasonId = 79611;
    $json = file_get_contents(__DIR__.'/../Data/season_extended.json');
    $return = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

    /** @var ApiClientInterface $clientMock */
    $clientMock = mockApiClient()
        ->shouldReceive('performAPICallWithJsonResponse')
        ->once()
        ->with(
            'get',
            'seasons/'.$seasonId.'/extended',
        )
        ->andReturn($return)
        ->getMock();
    $seasons = new Seasons($clientMock);
    $result = $seasons->extended($seasonId);
    $this->assertNotNull($result->id);
    $this->assertNotNull($result->episodes);
});
