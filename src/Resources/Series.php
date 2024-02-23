<?php

declare(strict_types=1);

namespace Days85\Tvdb\Resources;

use Carbon\Carbon;
use Days85\Tvdb\DataParser;
use Days85\Tvdb\Models\EpisodeBaseRecord;
use Days85\Tvdb\Models\SeriesBaseRecord;
use Days85\Tvdb\Models\SeriesExtendedRecord;
use InvalidArgumentException;

class Series extends AbstractResource
{
    public const SEASON_TYPE_DEFAULT = 'default';

    public const SEASON_TYPE_OFFICIAL = 'official';

    public const SEASON_TYPE_DVD = 'dvd';

    public const SEASON_TYPE_ABSOLUTE = 'absolute';

    public const SEASON_TYPE_ALTERNATE = 'alternate';

    public const SEASON_TYPE_REGIONAL = 'regional';

    public static function isValidSeasonType(string $type): bool
    {
        return in_array(
            $type,
            [
                static::SEASON_TYPE_ABSOLUTE,
                static::SEASON_TYPE_ALTERNATE,
                static::SEASON_TYPE_DEFAULT,
                static::SEASON_TYPE_DVD,
                static::SEASON_TYPE_OFFICIAL,
                static::SEASON_TYPE_REGIONAL,
            ]
        );
    }

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
        string $seasonType = self::SEASON_TYPE_DEFAULT,
        string $lang = '',
        int $episodeNumber = -1,
        ?Carbon $airDate = null,
    ): array {
        if (! static::isValidSeasonType($seasonType)) {
            throw new InvalidArgumentException('Given season type is not valid');
        }

        $arguments = ['page' => $page];
        $path = 'series/'.$id.'/episodes/'.$seasonType;
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
