<?php
declare(strict_types=1);

namespace Days85\Tvdb\Resources;

use Days85\Tvdb\DataParser;
use Days85\Tvdb\Models\SearchResult;
use InvalidArgumentException;

class Search extends AbstractResource
{
    const array VALID_OPTIONAL_PARAMETERS = [
        "type",
        "year",
        "offset",
        "company",
        "country",
        "director",
        "language",
        "primaryType",
        "network",
        "remote_id",
        "limit",
    ];

    public static function isValidOptionalParameter(string $key): bool
    {
        return in_array($key, static::VALID_OPTIONAL_PARAMETERS);
    }

    /**
     * @return SearchResult[]
     */
    public function search(string $searchQuery, array $optionalParameters = []): array
    {
        $options = ['query' => []];
        foreach ($optionalParameters as $key => $value) {
            if (static::isValidOptionalParameter($key) === false) {
                throw new InvalidArgumentException($key." is not a valid search argument!");
            }
            $options['query'][$key] = $value;
        }
        $options['query']["query"] = $searchQuery;

        $json = $this->parent->performAPICallWithJsonResponse('get', 'search', $options);
        return DataParser::parseDataArray($json, SearchResult::class);
    }
}
