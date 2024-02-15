<?php
declare(strict_types = 1);

namespace Days85\Tvdb\Models;

class SeriesBaseRecord
{
    public int $id;
    public ?string $name;
    public ?string $slug;
}
