<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

class ArtworkBaseRecord
{
    public int $id;

    public string $image;

    public ?string $language;

    public float|int|null $score;

    public string $thumbnail;

    public int $type;
}
