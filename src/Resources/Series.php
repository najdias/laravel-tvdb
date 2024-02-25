<?php

declare(strict_types=1);

namespace Days85\Tvdb\Resources;

use Carbon\Carbon;
use Days85\Tvdb\DataParser;
use Days85\Tvdb\Enums\SeasonType;
use Days85\Tvdb\Models\EpisodeBaseRecord;
use Days85\Tvdb\Models\SeriesBaseRecord;
use Days85\Tvdb\Models\SeriesExtendedRecord;

class Series extends AbstractResource
{
    public function simple(int $id): SeriesBaseRecord
    {
        $json = $this->parent
            ->performAPICallWithJsonResponse('get', 'series/'.$id);

        return DataParser::parseData($json, SeriesBaseRecord::class);
    }

    public function extended(int $id): SeriesExtendedRecord
    {
        $json = $this->parent
            ->performAPICallWithJsonResponse('get', 'series/'.$id.'/extended');

        return DataParser::parseData($json, SeriesExtendedRecord::class);
    }

    /**
     * @return EpisodeBaseRecord[]
     */
    public function episodes(
        int $id,
        int $season = 0,
        int $page = 0,
        SeasonType $seasonType = SeasonType::DEFAULT,
        string $lang = '',
        int $episodeNumber = -1,
        ?Carbon $airDate = null,
    ): array {
        $arguments = ['page' => $page];
        $path = 'series/'.$id.'/episodes/'.$seasonType->value;
        if (! empty($lang)) {
            $path .= '/'.$lang;
        } else {
            $arguments['season'] = $season;
        }
        if ($episodeNumber > -1) {
            $arguments['episodeNumber'] = $episodeNumber;
        }
        if (! is_null($airDate)) {
            $arguments['airDate'] = $airDate->toDateString();
        }
        $options = ['query' => $arguments];
        $json = $this->parent
            ->performAPICallWithJsonResponse('get', $path, $options);

        $episodes = $json['episodes'] ?? [];

        return DataParser::parseDataArray($episodes, EpisodeBaseRecord::class);
    }
}
