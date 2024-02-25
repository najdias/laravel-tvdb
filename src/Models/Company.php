<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

class Company
{
    public ?string $activeDate;

    /**
     * @var Alias[]|null
     */
    public ?array $aliases;

    public ?string $country;

    public int $id;

    public ?string $inactiveDate;

    public string $name;

    /**
     * @var string[]|null
     */
    public ?array $nameTranslations;

    /**
     * @var string[]|null
     */
    public ?array $overviewTranslations;

    public ?int $primaryCompanyType;

    public string $slug;

    public ?ParentCompany $parentCompany;

    /**
     * @var TagOption[]|null
     */
    public ?array $tagOptions;
}
