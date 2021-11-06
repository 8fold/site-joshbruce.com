<?php

use JoshBruce\DynamicSite\Server;

beforeEach(function() {
    // This somewhat unreadable one-liner basically creates a fully qualified
    // path to the root of the project, without using relative syntax

    // @phpstan-ignore-next-line
    $this->projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

    serverGlobals();

    // @phpstan-ignore-next-line
    $this->contentRoot = $this->projectRoot . $_SERVER['CONTENT_FOLDER'];
});

it('has expected file name and content root', function() {
    // @phpstan-ignore-next-line
    $projectRoot = $this->projectRoot;

    expect(
        Server::init(serverGlobals(), $projectRoot)->requestFileName()
    )->toBe(
        ''
    );

    expect(
        Server::init(serverGlobals(), $projectRoot)->contentRoot()
    )->toBe(
        __DIR__ . '/test-content/content'
    );
})->group('server');

it('limits request methods', function() {
    // @phpstan-ignore-next-line
    $projectRoot = $this->projectRoot;

    expect(
        Server::init(serverGlobals(), $projectRoot)
            ->isRequestingUnsupportedMethod()
    )->toBeFalse();

    $serverGlobals = serverGlobals();
    $serverGlobals['REQUEST_METHOD'] = 'INVALID';

    expect(
        Server::init($serverGlobals, $projectRoot)
            ->isRequestingUnsupportedMethod()
    )->toBeTrue();
})->group('server');

it('has required variables', function() {
    // @phpstan-ignore-next-line
    $projectRoot = $this->projectRoot;

    expect(
        Server::init(serverGlobals(), $projectRoot)
            ->isMissingRequiredValues()
    )->toBeFalse();

    $serverGlobals = serverGlobals();
    unset($serverGlobals['CONTENT_UP']);

    expect(
        Server::init($serverGlobals, $projectRoot)
            ->isMissingRequiredValues()
    )->toBeTrue();
})->group('server');
