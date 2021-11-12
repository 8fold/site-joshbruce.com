<?php

declare(strict_types=1);

use JoshBruce\Site\PageComponents;

use JoshBruce\Site\HttpRequest;
use JoshBruce\Site\HttpResponse;

use JoshBruce\Site\ServerGlobals;

use JoshBruce\Site\Tests\TestFileSystem;


it('can respond to sitemap request', function() {
    // serverGlobals('sitemap.xml');

    $xml = HttpResponse::from(
        request: HttpRequest::with(
            ServerGlobals::init()
                ->withRequestUri('/sitemap.xml')
                ->withRequestMethod('GET'), // TODO: indicates fragile tests
            TestFileSystem::init()
        )
    );

    expect(
        $xml->statusCode()
    )->toBe(
        200
    );

    expect(
        $xml->headers()
    )->toBe(
        ['Content-Type' => 'application/xml']
    );

    expect(
        str_contains($xml->body(), '<urlset')
    )->toBeTrue();

    expect(
        $xml->body()
    )->toBe(<<<xml
        <?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><url><loc>https://joshbruce.com</loc></url><url><loc>https://joshbruce.com/published-sub</loc></url><url><loc>https://joshbruce.com/published-sub/published-sub-sub</loc></url></urlset>
        xml
    );
})->group('request', 'response', 'sitemap');
