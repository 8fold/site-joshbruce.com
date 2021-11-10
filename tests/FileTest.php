<?php

declare(strict_types=1);

use JoshBruce\Site\File;

use JoshBruce\Site\Tests\TestFileSystem;

test('can generate canonical URL', function() {
    $fileSystem = TestFileSystem::init();
    $publicRoot = $fileSystem->publicRoot();

    expect(
       File::at($publicRoot . '/content.md', $fileSystem)->canonicalUrl()
    )->toBe(
       'https://joshbruce.com'
    );

    expect(
       File::at($publicRoot, $fileSystem)->canonicalUrl()
    )->toBe(
       'https://joshbruce.com'
    );
})->group('file');
