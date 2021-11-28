<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\Documents\Sitemap;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

it('can respond to sitemap request', function () {
    $_SERVER['APP_URL'] = 'http://jbruce-test.com';
    $_SERVER['CONTENT_FILENAME'] = 'content.md';

    expect(
        Sitemap::create(
            PlainTextFile::at(
                __DIR__ . '/../test-project-root/content/public/sitemap.xml',
                __DIR__ . '/../test-project-root/content/public'
            )
        ) . "\n"
    )->toBe(
        file_get_contents(__DIR__ . '/output.xml')
    );
})->group('sitemap', 'test-content');
