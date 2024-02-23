<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

class SeasonType
{
    public int $id;

    public string $name;

    public string $type;

    public ?string $alternateName;
}
