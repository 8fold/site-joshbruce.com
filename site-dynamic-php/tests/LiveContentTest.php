<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests;

use JoshBruce\SiteDynamic\Tests\LiveContentTestCase;

use JoshBruce\SiteDynamic\Http\RequestHandler;

use Nyholm\Psr7\ServerRequest;

use JoshBruce\SiteDynamic\Environment;

final class LiveContentTest extends LiveContentTestCase
{
    /**
     * @test
     *
     * @group live-content
     * @group content
     */
    public function content_not_article(): void // phpcs:ignore
    {
        $html = (string) self::rootContentResponse()->getBody();

        $this->assertTrue(str_contains($html, '<title'));

        $this->assertFalse(str_contains($html, '<article'));
    }

    /**
     * @test
     *
     * @group live-content
     * @group content
     */
    public function content_is_article(): void // phpcs:ignore
    {
        $html = (string) self::thisSiteResponse()->getBody();

        $this->assertTrue(str_contains($html, '<title'));

        $this->assertTrue(str_contains(
            $html,
            '<article typeof="BlogPosting" vocab="https://schema.org/">'
        ));

        $this->assertFalse(str_contains(
            $html,
            'href="/'
        ));

        $this->assertFalse(str_contains(
            $html,
            'src="/'
        ));
    }
}
