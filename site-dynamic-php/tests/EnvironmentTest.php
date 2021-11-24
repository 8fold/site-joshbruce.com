<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\Environment;

afterEach(function() {
    foreach ($_ENV as $var => $value) {
        if ($var !== 'SHELL_VERBOSITY') {
            unset($_ENV[$var]);
            unset($_SERVER[$var]);
        }
    }
});

it('has supported methods', function() {
    expect(
        Environment::with(__DIR__ . '/test-project-root')
            ->supportedMethods()
    )->toBeArray()->toBe([
       'GET'
    ]);
});

it('has expected folders', function() {
    expect(
        Environment::with(__DIR__ . '/test-project-root')
            ->isMissingFolders()
    )->toBeBool()->toBeFalse();
})->group('env', 'test-content');

it('has correct content root', function() {
    expect(
        Environment::with(__DIR__ . '/test-project-root')
            ->publicRoot()
    )->toBe(
        __DIR__ . '/test-project-root/content/public'
    );
})->group('env', 'test-content');

it('can validate .env', function() {
    expect(
        Environment::with(__DIR__ . '/test-project-root')
            ->isMissingVariables()
    )->toBeBool()->toBeFalse();
})->group('env', 'test-content');

it('fails silently', function() {
    expect(
        Environment::with(__DIR__ . '/test-project-root/failing-env')
            ->isMissingVariables()
    )->toBeBool()->toBeTrue();
});
