<?php

declare(strict_types=1);

namespace Days85\Tvdb\Resources;

use Days85\Tvdb\DataParser;
use Days85\Tvdb\Models\SeasonExtendedRecord;

class Seasons extends AbstractResource
{
    public function extended(int $id): SeasonExtendedRecord
    {
        $json = $this->parent
            ->performAPICallWithJsonResponse('get', 'seasons/'.$id.'/extended');

        return DataParser::parseData($json, SeasonExtendedRecord::class);
    }
}
