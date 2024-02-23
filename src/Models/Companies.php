<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

class Companies
{
    /**
     * @var Company[]|null
     */
    public ?array $studio;

    /**
     * @var Company[]|null
     */
    public ?array $network;

    /**
     * @var Company[]|null
     */
    public ?array $production;

    /**
     * @var Company[]|null
     */
    public ?array $distributor;

    /**
     * @var Company[]|null
     */
    public ?array $special_effects;
}
