<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

class ContentRating
{
    public int $id;

    public string $name;

    public string $country;

    public string $contentType;

    public int $order;

    public string $fullName;

    public ?string $description;
}
