<?php

use Days85\Tvdb\Exceptions\ParseException;
use Days85\Tvdb\Exceptions\ResourceNotFoundException;
use Days85\Tvdb\Exceptions\UnauthorizedException;
use GuzzleHttp\Psr7\Query;

it('creates error message', function () {
    $base = 'Error.';
    $path = 'foo/bar/baz';
    $parameters = ['foo' => 'bar', 'baz'];
    $this->assertEquals($base, ResourceNotFoundException::createErrorMessage($base));
    $expectedError = $base.sprintf(ResourceNotFoundException::PATH_MESSAGE, $path, '');
    $this->assertEquals($expectedError, ResourceNotFoundException::createErrorMessage($base, $path));
    $expectedError = $base.sprintf(
        ResourceNotFoundException::PATH_MESSAGE,
        $path,
        Query::build($parameters)
    );
    $this->assertEquals($expectedError, ResourceNotFoundException::createErrorMessage($base, $path, $parameters));
});

it('throws credentials exception', function () {
    $this->expectException(UnauthorizedException::class);
    $this->expectExceptionMessage(UnauthorizedException::CREDENTIALS_MESSAGE);
    throw UnauthorizedException::invalidCredentials();
});

it('throws token exception', function () {
    $this->expectException(UnauthorizedException::class);
    $this->expectExceptionMessage(UnauthorizedException::TOKEN_MESSAGE);
    throw UnauthorizedException::invalidToken();
});

it('throws not found exception', function () {
    $this->expectException(ResourceNotFoundException::class);
    $this->expectExceptionMessage(
        ResourceNotFoundException::createErrorMessage(ResourceNotFoundException::NOT_FOUND_MESSAGE)
    );
    throw ResourceNotFoundException::notFound();
});

it('throws not found exception with query', function () {
    $path = 'some/long/path';
    $options = ['query' => ['foobar']];
    $this->expectException(ResourceNotFoundException::class);
    $this->expectExceptionMessage(
        ResourceNotFoundException::createErrorMessage(
            ResourceNotFoundException::NOT_FOUND_MESSAGE,
            $path,
            $options['query']
        )
    );
    throw ResourceNotFoundException::notFound($path, $options);
});

it('throws no translation exception', function () {
    $this->expectException(ResourceNotFoundException::class);
    $this->expectExceptionMessage(
        ResourceNotFoundException::createErrorMessage(ResourceNotFoundException::NO_TRANSLATION_MESSAGE)
    );
    throw ResourceNotFoundException::noTranslationAvailable();
});

it('throws no translation exception with query', function () {
    $path = 'some/long/path';
    $options = ['query' => ['foobar']];
    $this->expectException(ResourceNotFoundException::class);
    $this->expectExceptionMessage(
        ResourceNotFoundException::createErrorMessage(
            ResourceNotFoundException::NO_TRANSLATION_MESSAGE,
            $path,
            $options['query']
        )
    );
    throw ResourceNotFoundException::noTranslationAvailable($path, $options);
});

it('throws decode exception', function () {
    $this->expectException(ParseException::class);
    $this->expectExceptionMessage(ParseException::DECODE_MESSAGE);
    throw ParseException::decode();
});

it('throws missing header exception', function () {
    $header = 'ABC';
    $this->expectException(ParseException::class);
    $this->expectExceptionMessage(sprintf(ParseException::HEADER_MESSAGE, $header));
    throw ParseException::missingHeader($header);
});

it('throws failed timestamp exception', function () {
    $timestamp = '2017-05-05 13...';
    $this->expectException(ParseException::class);
    $this->expectExceptionMessage(sprintf(ParseException::MODIFIED_MESSAGE, $timestamp));
    throw ParseException::lastModified($timestamp);
});
