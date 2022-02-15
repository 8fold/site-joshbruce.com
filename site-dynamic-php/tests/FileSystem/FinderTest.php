<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests\FileSystem;

use JoshBruce\SiteDynamic\Tests\LiveContentTestCase;

use JoshBruce\SiteDynamic\FileSystem\Finder;

use JoshBruce\SiteDynamic\Environment;

final class FinderTest extends LiveContentTestCase
{
    private const PUBLISHED_COUNT = 52;

    private const DRAFT_COUNT = 11;

    /**
     * @test
     *
     * @group finder
     * @group live-content
     */
    public function published_content_count(): void // phpcs:ignore
    {
        $publishedCount = self::PUBLISHED_COUNT;

        $this->assertCount(
            $publishedCount,
            Finder::init(self::pathToContentPublic(), Environment::CONTENT_FILENAME)
                ->publishedContent()
        );

        $this->assertSame(
            $publishedCount,
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
        $draftCount = self::DRAFT_COUNT;

        $this->assertCount(
            $draftCount,
            Finder::init(self::pathToContentPublic(), Environment::CONTENT_FILENAME)
                ->draftContent()
        );

        $this->assertSame(
            $draftCount,
            Finder::init(self::pathToContentPublic(), Environment::CONTENT_FILENAME)
                ->draftContent()->count()
        );
    }
}
