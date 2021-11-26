<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\Documents\Sitemap;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

it('can respond to sitemap request', function() {
    $_SERVER['APP_URL'] = 'http://jbruce-test.com';
    $_SERVER['CONTENT_FILENAME'] = 'content.md';

    expect(
        Sitemap::create(
            PlainTextFile::at(
                __DIR__ . '/../test-project-root/content/public/sitemap.xml',
                __DIR__ . '/../test-project-root/content/public'
            )
        )
    )->toBe(<<<xml
        <?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><url><loc>http://jbruce-test.com/published</loc><lastmod>2021-10-31</lastmod><priority>0.5</priority></url><url><loc>http://jbruce-test.com/published/published-2</loc><lastmod>2021-09-20</lastmod><priority>0.5</priority></url></urlset>
        xml
    );
})->group('sitemap', 'test-content');
