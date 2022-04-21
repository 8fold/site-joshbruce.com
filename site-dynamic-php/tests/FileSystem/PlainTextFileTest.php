<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests\FileSystem;

use SplFileInfo;

use JoshBruce\SiteDynamic\Tests\LiveContentTestCase;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

final class PlainTextFileTest extends LiveContentTestCase
{
    public static function migratedContent(): PlainTextFile
    {
        return PlainTextFile::at(
            self::pathToContentPrivate() . '/essays-and-editorials/software-development/on-constraints/internet-bandwidth/content.md', // phpcs:ignore
            self::pathToContentPrivate()
        );
    }

    /**
     * @test
     *
     * @group plain-text-file
     * @group live-content
     */
    public function template(): void
    {
        $file = PlainTextFile::at(
            self::pathToContentPublic() . '/sitemap.xml',
            self::pathToContentPublic()
        );

        $this->assertTrue($file->hasMetadata('template'));

        $this->assertSame('sitemap', $file->template());
    }

    /**
     * @test
     *
     * @group plain-text-file
     * @group live-content
     */
    public function title(): void
    {
        $this->assertSame(
            'Josh Bruce’s personal site',
            self::rootContentFile()->title()
        );
    }

    /**
     * @test
     *
     * @group plain-text-file
     * @group live-content
     */
    public function page_social_titles(): void // phpcs:ignore
    {
        $this->assertSame(
            'This site | Web development | Josh Bruce’s personal site',
            self::thisSiteContentFile()->pageTitle()
        );

        $this->assertSame(
            'This site | Josh Bruce’s personal site',
            self::thisSiteContentFile()->socialTitle()
        );
    }

    /**
     * @test
     *
     * @group plain-text-file
     * @group live-content
     */
    public function dates(): void
    {
        $file = self::migratedContent();

        $this->assertSame(20171204, $file->created());

        $this->assertSame(20211101, $file->updated());

        $this->assertSame(20211101, $file->moved());

        $this->assertSame('2021-11-01', $file->moved('Y-m-d'));

        $this->assertFalse(self::rootContentFile()->moved());
    }

    /**
     * @test
     *
     * @group plain-text-file
     * @group live-content
     */
    public function original(): void
    {
        $this->assertSame('', self::rootContentFile()->original());

        $this->assertSame(
            'https://medium.com/8fold-pub/on-constraints-internet-bandwidth-eab05c20e218 Medium',
            self::migratedContent()->original()
        );
    }
}
