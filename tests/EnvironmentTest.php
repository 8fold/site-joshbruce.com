<?php

use JoshBruce\Site\Environment;
use JoshBruce\Site\Http\Response;

test('Has response', function() {
    $serverGlobals = serverGlobals();
    $serverGlobals['CONTENT_FOLDER'] = 'does-not-exist';

    expect(
        Environment::init($serverGlobals)->response()->getBody()
    )->toBe(<<<html
        <!doctype html>
        <html lang="en"><head><title>Server error</title><meta charset="utf-8"></head><body><h1>502: Bad gateway (content)</h1><p>We're not sure what happened here. Please try again later.</p><p>If this error persists, please contact <a href="https://github.com/joshbruce">Josh Bruce</a>.</p></body></html>
        html
    );

    $serverGlobals = serverGlobals();
    unset($serverGlobals['CONTENT_UP']);
    unset($serverGlobals['CONTENT_FOLDER']);

    expect(
        Environment::init($serverGlobals)->response()->getBody()
    )->toBe(<<<html
        <!doctype html>
        <html lang="en"><head><title>Server error</title><meta charset="utf-8"></head><body><h1>500: Internal server error (environment)</h1><p>We're not sure what happened here. Please try again later.</p><p>If this error persists, please contact <a href="https://github.com/joshbruce">Josh Bruce</a>.</p></body></html>
        html
    );
})->group('environment');

test('Verifies', function () {
    expect(
        Environment::init(serverGlobals())->isVerified()
    )->toBeTrue();

    $serverGlobals = serverGlobals();
    $serverGlobals['CONTENT_FOLDER'] = 'does-not-exist';

    expect(
        Environment::init($serverGlobals)->isVerified()
    )->toBeFalse();

    $serverGlobals = serverGlobals();
    unset($serverGlobals['CONTENT_UP']);
    unset($serverGlobals['CONTENT_FOLDER']);

    expect(
        Environment::init($serverGlobals)->isVerified()
    )->toBeFalse();
})->group('environment');
