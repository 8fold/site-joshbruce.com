<?php

use JoshBruce\Site\Server;

it('has required variables', function() {
    expect(
        Server::init(serverGlobals())->response()->isOk()
    )->toBeTrue();

    $serverGlobals = serverGlobals();
    unset($serverGlobals['CONTENT_UP']);
    unset($serverGlobals['CONTENT_FOLDER']);

    $response = Server::init($serverGlobals)->response();
    expect(
        $response->isOk()
    )->toBeFalse();

    expect(
        $response->getBody()
    )->toBeString()->not->toBeEmpty();
})->group('server');

it('is immutable', function() {
    $server = Server::init(serverGlobals());

    $server->offsetSet('CONTENT_UP', 2);
    expect(
        $server->offsetGet('CONTENT_UP')
    )->toBe(
        0
    );

    $server->offsetUnset('CONTENT_UP');
    expect(
        $server->offsetGet('CONTENT_UP')
    )->toBe(
        0
    );
})->group('server');

test('Server exists', function() {
    expect(
        Server::init(serverGlobals())
    )->toBeInstanceOf(
        Server::class
    );
})->group('server');
