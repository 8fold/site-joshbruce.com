<?php

declare(strict_types=1);

use JoshBruce\Site\File;

use JoshBruce\Site\Tests\TestFileSystem;

use JoshBruce\Site\ServerGlobals;

it('generates expected titles', function() {
    $fileSystem = TestFileSystem::init();
    $publicRoot = $fileSystem->publicRoot();
    $parts      = explode('/', $publicRoot);
    $parts[]    = 'published-sub';
    $path       = implode('/', $parts);

    expect(
       File::at(localPath: $path . '/content.md', in: $fileSystem)->title()
    )->toBe(
       'Sub-folder content title'
    );

    $parts[]    = 'published-sub-sub';
    $path       = implode('/', $parts);

    expect(
       File::at(localPath: $path . '/content.md', in: $fileSystem)->title()
    )->toBe(
       'Sub-folder content title 2'
    );

    expect(
       File::at(localPath: $path . '/content.md', in: $fileSystem)->pageTitle()
    )->toBe(
       'Test content root | Sub-folder content title | Sub-folder content title 2'
    );
})->group('file');

it('can generate canonical URL', function() {
    $fileSystem = TestFileSystem::init();
    $publicRoot = $fileSystem->publicRoot();

    expect(
       File::at($publicRoot . '/content.md', $fileSystem)->canonicalUrl()
    )->toBe(
       ServerGlobals::init()->appUrl()
    );

    expect(
       File::at($publicRoot, $fileSystem)->canonicalUrl()
    )->toBe(
        ServerGlobals::init()->appUrl()
    );
})->group('file');
