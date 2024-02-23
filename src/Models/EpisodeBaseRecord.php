<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

use DateTime;

class EpisodeBaseRecord
{
    public ?string $aired;

    public int $id;

    public ?string $image;

    public float|int|null $imageType;

    public int $isMovie;

    public ?string $name;

    /**
     * @var string[]|null
     */
    public ?array $nameTranslations;

    /**
     * @var string[]|null
     */
    public ?array $overviewTranslations;

    public float|int|null $runtime;

    /**
     * @var SeasonBaseRecord[]|null
     */
    public ?array $seasons;

    public int $seriesId;

    public int $seasonNumber;

    public int $number;

    public ?DateTime $lastUpdated;

    public ?string $overview;

    public ?string $seasonName;

    public ?string $finaleType;

    public float|int|null $airsAfterSeason;

    public float|int|null $airsBeforeSeason;

    public float|int|null $airsBeforeEpisode;
}
