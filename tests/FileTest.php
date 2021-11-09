<?php

declare(strict_types=1);

use JoshBruce\Site\File;

use JoshBruce\Site\FileSystem;

test('can generate canonical URL', function() {
   expect(
       File::at(FileSystem::publicRoot() . '/content.md')->canonicalUrl()
   )->toBe(
       'https://joshbruce.com'
   );

    expect(
       File::at(FileSystem::publicRoot())->canonicalUrl()
   )->toBe(
       'https://joshbruce.com'
   );

    expect(
       File::at(FileSystem::publicRoot() . '/web-development')->canonicalUrl()
   )->toBe(
       'https://joshbruce.com/web-development'
   );

   expect(
        File::at(FileSystem::publicRoot() . '/web-development/content.md')
            ->canonicalUrl()
    )->toBe(
        'https://joshbruce.com/web-development'
    );
})->group('file');
