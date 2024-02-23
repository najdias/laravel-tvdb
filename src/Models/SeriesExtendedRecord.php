<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

class SeriesExtendedRecord extends SeriesBaseRecord
{
    public SeriesAirsDays $airsDays;

    public ?string $airsTime;

    public ?string $airsTimeUTC;

    /**
     * @var ArtworkBaseRecord[]
     */
    public array $artworks;

    /**
     * @var Character[]
     */
    public array $characters;

    /**
     * @var GenreBaseRecord[]
     */
    public array $genres;

    /**
     * @var RemoteID[]
     */
    public array $remoteIds;

    /**
     * @var SeasonBaseRecord[]
     */
    public array $seasons;

    /**
     * @var Trailer[]
     */
    public array $trailers;

    /**
     * @var Company[]
     */
    public array $companies;

    public Company $originalNetwork;

    public Company $latestNetwork;

    /**
     * @var TranslationExtended[]|null
     */
    public ?array $translations;

    /**
     * @var TagOption[]|null
     */
    public ?array $tags;

    /**
     * @var ContentRating[]|null
     */
    public ?array $contentRatings;

    public ?string $overview;

    /**
     * @var SeasonType[]
     */
    public array $seasonTypes;

    public function getIMDBId(): ?string
    {
        foreach ($this->remoteIds as $remoteId) {
            if ($remoteId->type === 2) {
                return $remoteId->id;
            }
        }

        return null;
    }
}
