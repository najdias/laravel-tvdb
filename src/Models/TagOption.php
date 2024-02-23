<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

class TagOption
{
    public ?string $helpText;

    public int $id;

    public string $name;

    public int $tag;

    public string $tagName;
}
