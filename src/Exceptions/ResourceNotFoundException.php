<?php
declare(strict_types=1);

namespace Days85\Tvdb\Exceptions;

use Exception;
use GuzzleHttp\Psr7\Query;

class ResourceNotFoundException extends Exception
{
    const string NOT_FOUND_MESSAGE = 'Could not find the requested resource!';
    const string NO_TRANSLATION_MESSAGE = 'There is no translation available for the requested language!';
    const string PATH_MESSAGE = ' Requested path: %s [parameters: %s]';

    public static function createErrorMessage(string $baseMessage, string $path = null, array $parameters = []): string
    {
        $errorMessage = $baseMessage;
        if ($path !== null) {
            $errorMessage .= sprintf(
                static::PATH_MESSAGE,
                $path,
                Query::build($parameters)
            );
        }
        return $errorMessage;
    }

    public static function notFound(string $path = null, array $options = []): ResourceNotFoundException
    {
        $query = [];
        if (array_key_exists('query', $options)) {
            $query = $options['query'];
        }
        return new ResourceNotFoundException(static::createErrorMessage(static::NOT_FOUND_MESSAGE, $path, $query));
    }

    public static function noTranslationAvailable(string $path = null, array $options = []): ResourceNotFoundException
    {
        $query = [];
        if (array_key_exists('query', $options)) {
            $query = $options['query'];
        }
        return new ResourceNotFoundException(static::createErrorMessage(static::NO_TRANSLATION_MESSAGE, $path, $query));
    }
}
