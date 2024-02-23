<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

class Translation extends TranslationSimple
{
    /**
     * @var string[]
     */
    public array $aliases;

    public bool $isAlias;

    public bool $isPrimary;

    public ?string $name;

    public ?string $overview;
}
