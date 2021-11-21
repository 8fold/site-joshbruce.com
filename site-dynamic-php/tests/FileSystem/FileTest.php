<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\FileSystem\File;

use JoshBruce\SiteDynamic\FileSystem\Finder;

test('can instantiate file', function() {
    expect(
        File::at(
            Finder::init()->publicRoot() . '/content.md',
            Finder::init()->publicRoot()
        )
    )->toBeInstanceOf(
        File::class
    );
})->group('file', 'live-content');

test('can get title', function() {
    expect(
        File::at(
            Finder::init()->publicRoot() . '/content.md',
            Finder::init()->publicRoot()
        )->title()
    )->toBeString()->toBe(
        "Josh Bruce’s personal site"
    );
})->group('file', 'live-content');
