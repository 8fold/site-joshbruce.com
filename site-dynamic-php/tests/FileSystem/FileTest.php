<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\FileSystem\File;

test('can be instantiated', function() {
    expect(
        File::at(
            __DIR__ . '/../test-project-root/content/public/content.md',
            __DIR__ . '/../test-project-root/content/public'
        )->mimetype()->name()
    )->toBe('html');

    expect(
        File::from(
            new \SplFileInfo(
                __DIR__ . '/../test-project-root/content/public/content.md'
            ),
            __DIR__ . '/../test-project-root/content/public'
        )->mimetype()->name()
    )->toBe('html');
})->group('file', 'test-content');
