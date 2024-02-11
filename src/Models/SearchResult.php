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
    public string $extendedTitle;
    /**
     * @var string[]
     */
    public array $genres;
    public string $id;
    public string $imageUrl;
    public string $name;
    public string $name_translated;
    public string $officialList;
    public string $overview;
    /**
     * @var string[]
     */
    public array $overview_translated;
    /**
     * @var string[]
     */
    public array $posters;
    public string $primaryLanguage;
    public string $primaryType;
    public string $status;
    /**
     * @var string[]
     */
    public array $translationsWithLang;
    public string $tvdb_id;
    public string $type;
    public string $year;
    public string $thumbnail;
    public string $poster;
    /**
     * @var array
     */
    public array $translations;
    public bool $is_official;
    /**
     * @var RemoteId[]
     */
    public array $remote_ids;
    public string $network;
    public string $title;
    /**
     * @var array
     */
    public array $overviews;
    public ?string $first_air_time;
    public string $objectID;
    public string $slug;
    /**
     * @var string[]|null
     */
    public ?array $studios;

    public function getLocalizedName(string $lang) : string
    {
        return ($this->translations[$lang] ?? "");
    }

    public function getLocalizedOverview(string $lang) : string
    {
        return ($this->overviews[$lang] ?? "");
    }
}
