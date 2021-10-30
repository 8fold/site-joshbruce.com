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

// it('is immutable', function() {
//     $server = Server::init(serverGlobals());

//     $server->offsetSet('CONTENT_UP', 2);
//     expect(
//         $server->offsetGet('CONTENT_UP')
//     )->toBe(
//         0
//     );

//     $server->offsetUnset('CONTENT_UP');
//     expect(
//         $server->offsetGet('CONTENT_UP')
//     )->toBe(
//         0
//     );
// })->group('server');

// test('Server exists', function() {
//     expect(
//         Server::init(serverGlobals())
//     )->toBeInstanceOf(
//         Server::class
//     );
// })->group('server');
