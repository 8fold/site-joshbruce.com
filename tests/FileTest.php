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
       'Sub-folder content title 2 | Sub-folder content title | Test content root'
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

it('can get description from front matter', function() {
   $fileSystem = TestFileSystem::init();
   $publicRoot = $fileSystem->publicRoot();

   // description field
   $file = File::at($publicRoot . '/content.md', $fileSystem);
   expect(
       $file->description()
   )->toBe(
       "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce felis arcu, molestie nec imperdiet eu, tristique ut elit. Curabitur “iaculis” sodales turpis a pellentesque’s. In ac nibh ex."
   );

   // derived description from content, short
   $file = File::at($publicRoot . '/published-sub/content.md', $fileSystem);
    expect(
        $file->description()
    )->toBe(
        "Short sentence. Something a little bit longer. Third sentence."
    );

    // derived description from content, long
    $file = File::at($publicRoot . '/published-sub/published-sub-sub/content.md', $fileSystem);
    expect(
        $file->description()
    )->toBe(
        "The US Federal Government extended the tax filing deadline, which extended how long I could contribute to my Roth IRA for 2020."
    );

    expect(
        $file->description(400)
    )->toBe(
        "The US Federal Government extended the tax filing deadline, which extended how long I could contribute to my Roth IRA for 2020. So, the cash reserves I have will be going to try and maximize that contribution. I had a coaching session with a Wave Advisor to improve and verify my bookkeeping skills."
    );
})->group('markdown');
