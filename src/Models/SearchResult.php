<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

class SearchResult
{
    /**
     * @var string[]
     */
    public array $aliases;

    /**
     * @var string[]
     */
    public array $companies;

    public string $companyType;

    public string $country;

    public string $director;

    public string $extended_title;

    public ?string $first_air_time;

    /**
     * @var string[]
     */
    public array $genres;

    public string $id;

    public string $image_url;

    public string $name;

    public bool $is_official;

    public string $name_translated;

    public string $network;

    public string $objectID;

    public string $officialList;

    public string $overview;

    /**
     * @var array<string, string>
     */
    public array $overviews;

    /**
     * @var string[]
     */
    public array $overview_translated;

    public string $poster;

    /**
     * @var string[]
     */
    public array $posters;

    public string $primary_language;

    /**
     * @var RemoteID[]
     */
    public array $remote_ids;

    public string $status;

    public string $slug;

    /**
     * @var string[]|null
     */
    public ?array $studios;

    public string $title;

    public string $thumbnail;

    /**
     * @var array<string, string>
     */
    public array $translations;

    /**
     * @var string[]
     */
    public array $translationsWithLang;

    public string $tvdb_id;

    public string $type;

    public string $year;

    public function getLocalizedName(string $lang): string
    {
        return $this->translations[$lang] ?? '';
    }

    public function getLocalizedOverview(string $lang): string
    {
        return $this->overviews[$lang] ?? '';
    }
}
