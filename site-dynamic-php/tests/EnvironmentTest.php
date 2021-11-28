<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\Environment;

it('has correct content root', function () {
    $sut = Environment::with(
        __DIR__ . '/test-project-root/content/public',
        'http://com.jbruce-test',
        'test'
    );
    expect(
           $sut->publicRoot()
    )->toBe(
        __DIR__ . '/test-project-root/content/public'
    );

    expect(
        $sut->isMissingFolders()
    )->toBeFalse();
})->group('env', 'test-content');

it('can check for incorrect content root', function () {
    $sut = Environment::with(
        __DIR__ . '/test-nonexistent/content/public',
        'http://com.jbruce-test',
        'test'
    );

    expect(
        $sut->isMissingFolders()
    )->toBeTrue();
})->group('env', 'test-content');
