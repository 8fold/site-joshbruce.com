<?php

declare(strict_types=1);

use JoshBruce\Site\Content\Markdown;

use JoshBruce\Site\File;
use JoshBruce\Site\Tests\TestFileSystem;

it('can get description from front matter', function() {
   $fileSystem = TestFileSystem::init();
   $publicRoot = $fileSystem->publicRoot();

   // description field
   $file = File::at($publicRoot . '/content.md', $fileSystem);
   expect(
       Markdown::for($file, $fileSystem)->description()
   )->toBe(
       "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce felis arcu, molestie nec imperdiet eu, tristique ut elit. Curabitur &quot;iaculis&quot; sodales turpis a pellentesque's. In ac nibh ex."
   );

   // derived description from content, short
   $file = File::at($publicRoot . '/published-sub/content.md', $fileSystem);
    expect(
        Markdown::for($file, $fileSystem)->description()
    )->toBe(
        "Short sentence. Something a little bit longer. Third sentence."
    );

    // derived description from content, long
    $file = File::at($publicRoot . '/published-sub/published-sub-sub/content.md', $fileSystem);
    expect(
        Markdown::for($file, $fileSystem)->description()
    )->toBe(
        "Short sentence. Something a little bit longer. Third sentence. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce felis arcu, molestie nec imperdiet eu, tristique ut elit."
    );
})->group('markdown');
