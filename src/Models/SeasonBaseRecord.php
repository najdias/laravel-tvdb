<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

class SeasonBaseRecord
{
    public int $id;

    public ?string $image;

    public float|int|null $imageType;

    public ?string $name;

    /**
     * @var string[]|null
     */
    public ?array $nameTranslations;

    public int $number;

    /**
     * @var string[]|null
     */
    public ?array $overviewTranslations;

    public float|int|null $seriesId;

    public SeasonType $type;

    public Companies $companies;
}
