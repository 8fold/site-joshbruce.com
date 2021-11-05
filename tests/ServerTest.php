<?php

use JoshBruce\Site\Server;

it('has expected file name and content root', function() {
    expect(
        Server::init(serverGlobals(), __DIR__)->requestFileName()
    )->toBe(
        ''
    );

    expect(
        Server::init(serverGlobals(), __DIR__)->contentRoot()
    )->toBe(
        __DIR__ . '/test-content'
    );
})->group('server');

it('limits request methods', function() {
    expect(
        Server::init(serverGlobals(), __DIR__)->isRequestingUnsupportedMethod()
    )->toBeFalse();

    $serverGlobals = serverGlobals();
    $serverGlobals['REQUEST_METHOD'] = 'INVALID';

    expect(
        Server::init($serverGlobals, __DIR__)->isRequestingUnsupportedMethod()
    )->toBeTrue();
})->group('server');

it('has required variables', function() {
    expect(
        Server::init(serverGlobals(), __DIR__)->isMissingRequiredValues()
    )->toBeFalse();

    $serverGlobals = serverGlobals();
    unset($serverGlobals['CONTENT_UP']);

    expect(
        Server::init($serverGlobals, __DIR__)->isMissingRequiredValues()
    )->toBeTrue();
})->group('server');
