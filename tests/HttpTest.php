<?php

declare(strict_types=1);

use JoshBruce\Site\HttpResponse;
use JoshBruce\Site\HttpRequest;

use JoshBruce\Site\ServerGlobals;

use JoshBruce\Site\Tests\TestFileSystem;
use JoshBruce\Site\Tests\TestServerGlobals;

test('expected headers', function() {
    expect(
        HttpResponse::from(
            request: HttpRequest::with(
                ServerGlobals::init(),
                TestFileSystem::init()
            )
        )->headers()
    )->toBe(
        ['Content-Type' => 'text/html']
    );

    expect(
        HttpResponse::from(
            request: HttpRequest::with(
                ServerGlobals::init()
                    ->withRequestUri('/assets/css/main.min.css'),
                TestFileSystem::init()
            )
        )->headers()
    )->toBe(
        ['Content-Type' => 'text/css']
    );
})->group('response', 'request');

test('expected titles', function() {
    $body = HttpResponse::from(
        request: HttpRequest::with(
            ServerGlobals::init()->withRequestUri('/'),
            TestFileSystem::init()
        )
    )->body();

    expect(
        str_contains($body, "<title>Test content root</title>")
    )->toBeTrue();

    $body = HttpResponse::from(
        request: HttpRequest::with(
            ServerGlobals::init()->withRequestUri('/published-sub'),
            TestFileSystem::init()
        )
    )->body();

    expect(
        str_contains(
            $body,
            "<title>Sub-folder content title | Test content root</title>"
        )
    )->toBeTrue();

    $body = HttpResponse::from(
        request: HttpRequest::with(
            ServerGlobals::init()->withRequestUri('/something/invalid'),
            TestFileSystem::init()
        )
    )->body();

    expect(
        str_contains(
            $body,
            "<title>Page not found</title>"
        )
    )->toBeTrue();
})->group('response', 'request');

test('expected status codes', function() {
    expect(
        HttpResponse::from(
            request: HttpRequest::with(
                ServerGlobals::init()->withRequestUri('/'),
                TestFileSystem::init()
            )
        )->statusCode()
    )->toBeInt()->toBe(
        200
    );

    expect(
        HttpResponse::from(
            request: HttpRequest::with(
                ServerGlobals::init()->withRequestUri('/something/invalid'),
                TestFileSystem::init()
            )
        )->statusCode()
    )->toBeInt()->toBe(
        404
    );

    expect(
        HttpResponse::from(
            request: HttpRequest::with(
                ServerGlobals::init()->withRequestUri('/published-redirect'),
                TestFileSystem::init()
            )
        )->statusCode()
    )->toBeInt()->toBe(
        301
    );

    expect(
        HttpResponse::from(
            request: HttpRequest::with(
                ServerGlobals::init()->withRequestUri('/published-redirect/302'),
                TestFileSystem::init()
            )
        )->statusCode()
    )->toBeInt()->toBe(
        302
    );

    expect(
        HttpResponse::from(
            request: HttpRequest::with(
                ServerGlobals::init()->withRequestUri('/published-redirect/500'),
                TestFileSystem::init()
            )
        )->statusCode()
    )->toBeInt()->toBe(
        500
    );

    $headers = HttpResponse::from(
        request: HttpRequest::with(
            ServerGlobals::init()->withRequestUri('/published-redirect/302'),
            TestFileSystem::init()
        )
    )->headers();

    expect(
        array_key_exists('Location', $headers)
    )->toBeTrue();
})->group('response', 'request');

it('can handle 405 response', function() {
    expect(
        HttpResponse::from(
            request: HttpRequest::with(
                ServerGlobals::init()->withRequestMethod('post'),
                TestFileSystem::init()
            )
        )->statusCode()
    )->toBeInt()->toBe(
        405
    );
});

it('can handle 500 response', function() {
    $serverGlobals = TestServerGlobals::init()->unsetAppEnv();

    expect(
        HttpResponse::from(
            request: HttpRequest::with($serverGlobals, TestFileSystem::init())
        )->statusCode()
    )->toBeInt()->toBe(
        500
    );

    $body = HttpResponse::from(
        request: HttpRequest::with($serverGlobals, TestFileSystem::init())
    )->body();

    expect(
        str_contains(
            $body,
            "<title>Server error</title>"
        )
    )->toBeTrue();

    $serverGlobals->resetAppEnv();

})->group('response', 'request');
