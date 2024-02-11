<?php

use Days85\Tvdb\ApiClient;
use Days85\Tvdb\Resources\Authentication;

it('can login with api key', function () {
    $apiKey = 'FOO';
    config()->set('tvdb.apikey', $apiKey);
    $apiClientMock = setApiClientMockLoginData($apiKey);
    $resource = new Authentication($apiClientMock);
    $this->assertInstanceOf(ApiClient::class, $resource->login());
});
