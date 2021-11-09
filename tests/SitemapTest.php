<?php

declare(strict_types=1);

use JoshBruce\Site\PageComponents;

use JoshBruce\Site\HttpRequest;
use JoshBruce\Site\HttpResponse;

it('can respond to sitemap request', function() {
    serverGlobals('sitemap.xml');

    $xml = HttpResponse::from(
        request: HttpRequest::fromGlobals()
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
    )->toBe('');
})->group('sitemap', 'focus');
