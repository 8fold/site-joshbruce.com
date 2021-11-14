<?php

declare(strict_types=1);

use JoshBruce\Site\File;

use JoshBruce\Site\Tests\TestFileSystem;

use JoshBruce\Site\ServerGlobals;

test('can generate canonical URL', function() {
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
