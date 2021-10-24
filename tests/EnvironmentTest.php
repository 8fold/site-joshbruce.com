<?php

use JoshBruce\Site\Environment;
use JoshBruce\Site\Http\Response;

beforeEach(function() {
    $this->serverGlobals = $_SERVER;
    $this->serverGlobals['CONTENT_UP'] = 0;
    $this->serverGlobals['CONTENT_FOLDER'] = '/tests/test-content';
});

test('Has response', function() {
    expect(
        Environment::init($this->serverGlobals)->response()->getBody()
    )->toBe(<<<html
        <!doctype html>
        <html>
            <head>
                <title>Josh Bruce's personal site</title>
                <style>
                    h1 {
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <h1>The domain of Josh Bruce</h1>
                <p>This content was successfully found.</p>
            </body>
        </html>
        html
    );

    $serverGlobals = $this->serverGlobals;
    $serverGlobals['CONTENT_FOLDER'] = 'does-not-exist';

    expect(
        Environment::init($serverGlobals)->response()->getBody()
    )->toBe(<<<html
        <!doctype html>
        <html>
            <head>
                <title>Server error | Josh Bruce's personal site</title>
            </head>
            <body>
                <h1>502: Bad gateway (content)</h1>
                <p>We're not sure what happened here. Please try again later.</p>
                <p>If this error persists, please contact <a href="https://github.com/joshbruce">Josh Bruce</a>.</p>
            </body>
        </html>
        html
    );

    $serverGlobals = $this->serverGlobals;
    unset($serverGlobals['CONTENT_UP']);
    unset($serverGlobals['CONTENT_FOLDER']);

    expect(
        Environment::init($serverGlobals)->response()->getBody()
    )->toBe(<<<html
        <!doctype html>
        <html>
            <head>
                <title>Server error | Josh Bruce's personal site</title>
            </head>
            <body>
                <h1>500: Internal server error (environment)</h1>
                <p>We're not sure what happened here. Please try again later.</p>
                <p>If this error persists, please contact <a href="https://github.com/joshbruce">Josh Bruce</a>.</p>
            </body>
        </html>
        html
    );
})->group('environment');

test('Verifies', function () {
    expect(
        Environment::init($this->serverGlobals)->isVerified()
    )->toBeTrue();

    $serverGlobals = $this->serverGlobals;
    $serverGlobals['CONTENT_FOLDER'] = 'does-not-exist';

    expect(
        Environment::init($serverGlobals)->isVerified()
    )->toBeFalse();

    $serverGlobals = $this->serverGlobals;
    unset($serverGlobals['CONTENT_UP']);
    unset($serverGlobals['CONTENT_FOLDER']);

    expect(
        Environment::init($serverGlobals)->isVerified()
    )->toBeFalse();
})->group('environment');
