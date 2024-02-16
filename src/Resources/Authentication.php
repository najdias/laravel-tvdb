<?php

declare(strict_types=1);

namespace Days85\Tvdb\Resources;

use Days85\Tvdb\ApiClientInterface;
use Days85\Tvdb\Exceptions\UnauthorizedException;

class Authentication extends AbstractResource
{
    public function login(): ApiClientInterface
    {
        $apikey = config('tvdb.apikey');
        $pin = config('tvdb.pin');

        $arguments = ['apikey' => $apikey];
        if (! empty($pin)) {
            $arguments['pin'] = $pin;
        }

        $data = $this->parent->performAPICallWithJsonResponse(
            'post',
            'login',
            [
                'body' => json_encode($arguments),
                'http_errors' => true,
            ]
        );

        if (! array_key_exists('token', $data)) {
            throw UnauthorizedException::invalidCredentials();
        }

        $this->parent->setToken($data['token']);

        return $this->parent;
    }
}
