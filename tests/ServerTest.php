<?php

use JoshBruce\Site\Server;

it('expected local file path', function() {
    expect(
        Server::init(serverGlobals())->filePathForRequest()
    )->toBe(
        '/content.md'
    );

    $serverGlobals = serverGlobals();
    $serverGlobals['REQUEST_URI'] = '/some.file';

    expect(
        Server::init($serverGlobals)->filePathForRequest()
    )->toBe(
        '/some.file'
    );
})->group('server');

it('can determine if request is for a file', function() {
    expect(
        Server::init(serverGlobals())->isRequestingFile()
    )->toBeFalse();

    $serverGlobals = serverGlobals();
    $serverGlobals['REQUEST_URI'] = '/some.file';

    expect(
        Server::init($serverGlobals)->isRequestingFile()
    )->toBeTrue();
})->group('server');

it('limits request methods', function() {
    expect(
        Server::init(serverGlobals())->isUsingUnsupportedMethod()
    )->toBeFalse();

    $serverGlobals = serverGlobals();
    $serverGlobals['REQUEST_METHOD'] = 'INVALID';

    expect(
        Server::init($serverGlobals)->isUsingUnsupportedMethod()
    )->toBeTrue();
})->group('server');

it('has required variables', function() {
    expect(
        Server::init(serverGlobals())->isMissingRequiredValues()
    )->toBeFalse();

    $serverGlobals = serverGlobals();
    unset($serverGlobals['CONTENT_UP']);

    expect(
        Server::init($serverGlobals)->isMissingRequiredValues()
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
