<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

class SeasonExtendedRecord extends SeasonBaseRecord
{
    /**
     * @var ArtworkBaseRecord[]
     */
    public array $artwork;

    /**
     * @var EpisodeBaseRecord[]
     */
    public array $episodes;

    /**
     * @var InspirationType[]
     */
    public array $trailers;

    /**
     * @var TagOption[]|null
     */
    public ?array $tagOptions;

    public string $country;
}
