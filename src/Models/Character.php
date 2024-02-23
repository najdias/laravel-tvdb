<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

class Character
{
    /**
     * @var Alias[]|null
     */
    public ?array $aliases;

    public float|int|null $episodeId;

    public int $id;

    public ?string $image;

    public bool $isFeatured;

    public float|int|null $movieId;

    public ?string $name;

    /**
     * @var string[]|null
     */
    public ?array $nameTranslations;

    /**
     * @var string[]|null
     */
    public ?array $overviewTranslations;

    public float|int|null $peopleId;

    public float|int|null $seriesId;

    public int $sort;

    public int $type;

    public string $url;

    public string $personName;

    public ?string $personImgURL;

    public ?string $peopleType;

    /**
     * @var TagOption[]|null
     */
    public ?array $tagOptions;
}
