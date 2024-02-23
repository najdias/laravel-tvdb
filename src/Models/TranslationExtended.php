<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

class TranslationExtended
{
    /**
     * @var Translation[]
     */
    public array $nameTranslations;

    /**
     * @var Translation[]
     */
    public array $overviewTranslations;

    /**
     * @var string[]
     */
    public array $alias;
}
