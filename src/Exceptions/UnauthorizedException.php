<?php
declare(strict_types = 1);

namespace Days85\Tvdb\Exceptions;

use Exception;

final class UnauthorizedException extends Exception
{
    public const CREDENTIALS_MESSAGE = 'Unauthorized; please provide valid credentials.';
    public const TOKEN_MESSAGE = 'Unauthorized; please provide valid token.';

    public static function invalidCredentials(): UnauthorizedException
    {
        return new UnauthorizedException(self::CREDENTIALS_MESSAGE);
    }

    public static function invalidToken(): UnauthorizedException
    {
        return new UnauthorizedException(self::TOKEN_MESSAGE);
    }
}
