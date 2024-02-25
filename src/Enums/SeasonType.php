<?php

declare(strict_types=1);

namespace Days85\Tvdb\Enums;

enum SeasonType: string
{
    case DEFAULT = 'default';
    case OFFICIAL = 'official';
    case DVD = 'dvd';
    case ABSOLUTE = 'absolute';
    case ALTERNATE = 'alternate';
    case REGIONAL = 'regional';
}
