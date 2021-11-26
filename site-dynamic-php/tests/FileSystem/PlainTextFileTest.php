<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

beforeEach(function() {
    $this->publicRoot = __DIR__ . '/../test-project-root/content/public';
    $this->publish2Content = $this->publicRoot .
        '/published/published-2/content.md';
});

it('can get page and social titles', function() {
    expect(
        PlainTextFile::at(
            $this->publish2Content,
            $this->publicRoot
        )->pageTitle()
    )->toBeString()->toBe(
        'Published content 2 | Published content | Test content home'
    );

    expect(
        PlainTextFile::at(
            $this->publish2Content,
            $this->publicRoot
        )->socialTitle()
    )->toBeString()->toBe(
        'Published content 2 | Test content home'
    );
})->group('plain-text-file', 'test-content');

it('can get title', function() {
    expect(
        PlainTextFile::at(
            $this->publish2Content,
            $this->publicRoot
        )->title()
    )->toBeString()->toBe(
        'Published content 2'
    );
})->group('plain-text-file', 'test-content');

it('can get description from front matter', function() {
   // description field
   $file = PlainTextFile::at(
       $this->publicRoot . '/content.md',
       $this->publicRoot
   );
    expect(
        PlainTextFile::at(
            $this->publicRoot . '/content.md',
            $this->publicRoot
        )->description()
    )->toBe(
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce felis arcu, molestie nec imperdiet eu, tristique ut elit. Curabitur “iaculis” sodales turpis a pellentesque’s. In ac nibh ex."
    );

    // derived description from content, short
    expect(
        PlainTextFile::at(
            $this->publicRoot . '/published/content.md',
            $this->publicRoot
        )->description()
    )->toBe(
        "Short sentence. Something a little bit longer. Third sentence."
    );

    // derived description from content, long
    expect(
        PlainTextFile::at(
            $this->publicRoot . '/published/published-2/content.md',
            $this->publicRoot
        )->description()
    )->toBe(
        "Short sentence. Something a little bit longer. Third sentence. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce felis arcu, molestie nec imperdiet eu, tristique ut elit."
    );
})->group('plain-text-file', 'test-content');
