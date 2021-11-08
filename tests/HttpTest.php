<?php

declare(strict_types=1);

use JoshBruce\Site\HttpResponse;
use JoshBruce\Site\HttpRequest;
// use JoshBruce\Site\ServerGlobals;
//
test('expected headers', function() {
    serverGlobals();

    expect(
        HttpResponse::from(
            request: HttpRequest::fromGlobals()
        )->headers()
    )->toBe(
        ['Content-Type' => 'text/html']
    );

    serverGlobals('/assets/css/main.min.css');

    expect(
        HttpResponse::from(
            request: HttpRequest::fromGlobals()
        )->headers()
    )->toBe(
        ['Content-Type' => 'text/css']
    );
})->group('response');

test('expected titles', function() {
    serverGlobals();

    $body = HttpResponse::from(
        request: HttpRequest::fromGlobals()
    )->body();

    expect(
        str_contains($body, "<title>Josh Bruce's personal site</title>")
    )->toBeTrue();

    serverGlobals('/finances');

    $body = HttpResponse::from(
        request: HttpRequest::fromGlobals()
    )->body();

    expect(
        str_contains(
            $body,
            "<title>Finances | Josh Bruce's personal site</title>"
        )
    )->toBeTrue();

    serverGlobals('/something-missing');

    $body = HttpResponse::from(
        request: HttpRequest::fromGlobals()
    )->body();

    expect(
        str_contains(
            $body,
            "<title>Page not found</title>"
        )
    )->toBeTrue();
})->group('response');

test('expected status codes', function() {
    serverGlobals();

    expect(
        HttpResponse::from(
            request: HttpRequest::fromGlobals()
        )->statusCode()
    )->toBeInt()->toBe(
        200
    );

    unset($_SERVER['APP_ENV']);

    expect(
        HttpResponse::from(
            request: HttpRequest::fromGlobals()
        )->statusCode()
    )->toBeInt()->toBe(
        500
    );

    serverGlobals();

    $_SERVER['REQUEST_METHOD'] = 'post';

    expect(
        HttpResponse::from(
            request: HttpRequest::fromGlobals()
        )->statusCode()
    )->toBeInt()->toBe(
        405
    );

    serverGlobals('/not-valid');

    expect(
        HttpResponse::from(
            request: HttpRequest::fromGlobals()
        )->statusCode()
    )->toBeInt()->toBe(
        404
    );
})->group('response');
//
// test('can check request is valid', function() {
//     serverGlobals();
//
//     expect(
//         HttpRequest::init()->isMissingRequiredValues()
//     )->toBeFalse();
//
//     expect(
//         HttpRequest::init()->isUnsupportedMethod()
//     )->toBeFalse();
//
//     expect(
//         HttpRequest::init()->isNotFound()
//     )->toBeFalse();
//
//     serverGlobals('/not-valid');
//     unset($_SERVER['APP_ENV']);
//     $_SERVER['REQUEST_METHOD'] = 'post';
//
//     expect(
//         HttpRequest::init()->isMissingRequiredValues()
//     )->toBeTrue();
//
//     expect(
//         HttpRequest::init()->isUnsupportedMethod()
//     )->toBeTrue();
//
//     expect(
//         HttpRequest::init()->isNotFound()
//     )->toBeTrue();
// })->group('request');
//
// it('uses server globals', function() {
//     serverGlobals();
//
//     expect(
//         ServerGlobals::init()->hasAppEnv()
//     )->toBeTrue();
//
//     unset($_SERVER['APP_ENV']);
//
//     expect(
//         ServerGlobals::init()->hasAppEnv()
//     )->toBeFalse();
// })->group('globals');
