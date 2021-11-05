<?php

use JoshBruce\Site\Server;

beforeEach(function() {
    // This somewhat unreadable one-liner basically creates a fully qualified
    // path to the root of the project, without using relative syntax
    $this->projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

    serverGlobals();

    $this->contentRoot = $this->projectRoot . $_SERVER['CONTENT_FOLDER'];
});

it('has expected file name and content root', function() {
    expect(
        Server::init(serverGlobals(), $this->projectRoot)->requestFileName()
    )->toBe(
        ''
    );

    expect(
        Server::init(serverGlobals(), $this->projectRoot)->contentRoot()
    )->toBe(
        __DIR__ . '/test-content/content'
    );
})->group('server');

it('limits request methods', function() {
    expect(
        Server::init(serverGlobals(), $this->projectRoot)
            ->isRequestingUnsupportedMethod()
    )->toBeFalse();

    $serverGlobals = serverGlobals();
    $serverGlobals['REQUEST_METHOD'] = 'INVALID';

    expect(
        Server::init($serverGlobals, $this->projectRoot)
            ->isRequestingUnsupportedMethod()
    )->toBeTrue();
})->group('server');

it('has required variables', function() {
    expect(
        Server::init(serverGlobals(), $this->projectRoot)
            ->isMissingRequiredValues()
    )->toBeFalse();

    $serverGlobals = serverGlobals();
    unset($serverGlobals['CONTENT_UP']);

    expect(
        Server::init($serverGlobals, $this->projectRoot)
            ->isMissingRequiredValues()
    )->toBeTrue();
})->group('server');
