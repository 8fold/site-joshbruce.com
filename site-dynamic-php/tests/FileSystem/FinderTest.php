<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests;

use JoshBruce\SiteDynamic\Tests\LiveContentTestCase;

use JoshBruce\SiteDynamic\FileSystem\Finder;

use JoshBruce\SiteDynamic\Environment;

final class FinderTest extends LiveContentTestCase
{
    /**
     * @test
     *
     * @group finder
     * @group live-content
     */
    public function published_content_count(): void // phpcs:ignore
    {
        $this->assertCount(
            42,
            Finder::init(self::pathToContentPublic(), Environment::CONTENT_FILENAME)
                ->publishedContent()
        );

        $this->assertSame(
            42,
            Finder::init(self::pathToContentPublic(), Environment::CONTENT_FILENAME)
                ->publishedContent()->count()
        );
    }

    /**
     * @test
     *
     * @group finder
     * @group live-content
     */
    public function draft_content_count(): void // phpcs:ignore
    {
        $this->assertCount(
            9,
            Finder::init(self::pathToContentPublic(), Environment::CONTENT_FILENAME)
                ->draftContent()
        );

        $this->assertSame(
            9,
            Finder::init(self::pathToContentPublic(), Environment::CONTENT_FILENAME)
                ->draftContent()->count()
        );
    }
}
