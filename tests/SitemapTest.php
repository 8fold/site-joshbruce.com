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
    )->toBe(<<<xml
        <?xml version = "1.0" encoding = "UTF-8" standalone = "yes" ?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><url><loc>https://joshbruce.com</loc></url><url><loc>https://joshbruce.com/design-your-life</loc></url><url><loc>https://joshbruce.com/design-your-life/motivators</loc></url><url><loc>https://joshbruce.com/finances/budgeting</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20210301</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20210315</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20210401</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20210415</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20210501</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20210515</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20210601</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20210615</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20210701</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20210715</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20210801</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20210815</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20210901</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20210915</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20211001</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20211015</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck/20211101</loc></url><url><loc>https://joshbruce.com/finances/building-wealth-paycheck-to-paycheck</loc></url><url><loc>https://joshbruce.com/finances</loc></url><url><loc>https://joshbruce.com/finances/investment-policy</loc></url><url><loc>https://joshbruce.com/health-and-wellness</loc></url><url><loc>https://joshbruce.com/legal</loc></url><url><loc>https://joshbruce.com/software-development</loc></url><url><loc>https://joshbruce.com/software-development/why-dont-you-use</loc></url><url><loc>https://joshbruce.com/web-development/2021-site-in-depth</loc></url><url><loc>https://joshbruce.com/web-development</loc></url><url><loc>https://joshbruce.com/web-development/modern-web-development</loc></url><url><loc>https://joshbruce.com/web-development/my-history-on-the-web</loc></url><url><loc>https://joshbruce.com/web-development/on-constraints</loc></url><url><loc>https://joshbruce.com/web-development/on-constraints/internet-bandwidth</loc></url><url><loc>https://joshbruce.com/web-development/refactoring-re-engineering-and-rebuilding</loc></url><url><loc>https://joshbruce.com/web-development/site-stats</loc></url><url><loc>https://joshbruce.com/web-development/static-dynamic-and-interactive</loc></url></urlset>
        xml
    );
})->group('sitemap');
