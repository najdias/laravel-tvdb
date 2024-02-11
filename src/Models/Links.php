<?php
declare(strict_types=1);

namespace Days85\Tvdb\Models;

class Links
{
    public ?string $prev;
    public ?string $self;
    public ?string $next;
    public int $total_items;
    public int $page_size;
}
