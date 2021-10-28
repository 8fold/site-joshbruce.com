<?php

use JoshBruce\Site\Environment;

use JoshBruce\Site\Server;

use JoshBruce\Site\Response;

test('Has response', function() {
    $serverGlobals = serverGlobals();
    $serverGlobals['CONTENT_FOLDER'] = 'does-not-exist';

    $startTime = hrtime(true);

    $body = Environment::init(
        Server::init($serverGlobals)
    )->response()->getBody();

    $endTime = hrtime(true);

    $elapsed = $endTime - $startTime;
    $ms      = $elapsed/1e+6;

    expect($ms)->toBeLessThan(22);

    expect(
        $body
    )->toBe(<<<html
        <!doctype html>
        <html lang="en"><head><title>Content error</title><meta charset="utf-8"></head><body><h1>502: Bad gateway (content)</h1><p>We’re not sure what happened here but we’re pretty sure it’s on us.</p><p>Please try again later.</p><p>If this error persists, please contact <a href="https://github.com/joshbruce">Josh Bruce</a>.</p></body></html>
        html
    );
})->group('environment');

test('Verifies', function () {
    expect(
        Environment::init(
            Server::init(serverGlobals())
        )->response()->isOk()
    )->toBeTrue();

    $serverGlobals = serverGlobals();
    $serverGlobals['CONTENT_FOLDER'] = 'does-not-exist';

    expect(
        Environment::init(
            Server::init($serverGlobals)
        )->response()->isOk()
    )->toBeFalse();
})->group('environment');
