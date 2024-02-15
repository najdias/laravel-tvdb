<?php
declare(strict_types=1);

namespace Days85\Tvdb\Exceptions;

use Exception;

class ParseException extends Exception
{
    public const string DECODE_MESSAGE = 'Could not decode JSON data';
    public const string HEADER_MESSAGE = 'Could not find %s in the provided headers';
    public const string MODIFIED_MESSAGE = 'Could not convert %s into a DateTime object';

    public static function decode(): ParseException
    {
        return new ParseException(static::DECODE_MESSAGE);
    }

    public static function missingHeader(string $headerName): ParseException
    {
        return new ParseException(sprintf(static::HEADER_MESSAGE, $headerName));
    }

    public static function lastModified(string $suppliedTimestamp): ParseException
    {
        return new ParseException(sprintf(static::MODIFIED_MESSAGE, $suppliedTimestamp));
    }
}
