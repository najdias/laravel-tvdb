<?php
declare(strict_types=1);

namespace Days85\Tvdb\Resources;

use Days85\Tvdb\ApiClientInterface;

interface ResourceInterface
{
    public function __construct(ApiClientInterface $parent);
}
