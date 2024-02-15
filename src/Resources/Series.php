<?php
declare(strict_types = 1);

namespace Days85\Tvdb\Resources;

use Days85\Tvdb\DataParser;
use Days85\Tvdb\Models\SeriesBaseRecord;

class Series extends AbstractResource
{
    public function simple(int $id): SeriesBaseRecord
    {
        $json = $this->parent
            ->performAPICallWithJsonResponse('get', 'series/' . $id);
        return DataParser::parseData($json, SeriesBaseRecord::class);
    }
}
