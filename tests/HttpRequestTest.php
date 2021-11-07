<?php

declare(strict_types=1);

use JoshBruce\Site\HttpRequest;

use JoshBruce\Site\ServerGlobals;

it('can check for required variables', function() {
    serverGlobals();

    expect(
        HttpRequest::init()->isMissingRequiredValues()
    )->toBeFalse();

    unset($_SERVER['APP_ENV']);

    expect(
        HttpRequest::init()->isMissingRequiredValues()
    )->toBeTrue();
})->group('request', 'focus');

it('uses server globals', function() {
    serverGlobals();

    expect(
        ServerGlobals::init()->hasAppEnv()
    )->toBeTrue();

    unset($_SERVER['APP_ENV']);

    expect(
        ServerGlobals::init()->hasAppEnv()
    )->toBeFalse();
})->group('globals', 'focus');
