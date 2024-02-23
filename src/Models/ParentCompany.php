<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

class ParentCompany
{
    public ?int $id;

    public ?string $name;

    public ?CompanyRelationShip $relation;
}
