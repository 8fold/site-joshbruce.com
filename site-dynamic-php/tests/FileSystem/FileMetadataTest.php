<?php

declare(strict_types=1);

use JoshBruce\Site\Dynamic\FileSystem\FileMetadata;

beforeEach(function() {
    $this->rootContentPath = Finder::init()->publicRoot() . '/content.md';
});

test('can instantiate metadata for file', function() {
    expect(
        FileMetadata::for($this->rootContentPath)
    )->toBeInstanceOf(
        FileMetadata::class
    );
})->group('file-metadata', 'live-content');
