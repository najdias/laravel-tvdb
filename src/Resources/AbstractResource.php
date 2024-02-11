<?php
declare(strict_types=1);

namespace Days85\Tvdb\Resources;

use Days85\Tvdb\ApiClientInterface;

abstract class AbstractResource implements ResourceInterface
{
    protected ApiClientInterface $parent;

    public function __construct(ApiClientInterface $parent)
    {
        $this->parent = $parent;
    }
}
