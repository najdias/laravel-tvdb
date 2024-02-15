<?php

use Days85\Tvdb\Models\SeriesBaseRecord;
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

    $clientMock = mockApiClient()
        ->shouldReceive('performAPICallWithJsonResponse')
        ->once()
        ->with(
            'get',
            'series/' . $seriesId,
        )
        ->andReturn($return)
        ->getMock();
    $series = new Series($clientMock);
    $result = $series->simple($seriesId);
    $this->assertEquals($seriesId, $result->id);
    $this->assertEquals($slug, $result->slug);
    $this->assertEquals($name, $result->name);
});
