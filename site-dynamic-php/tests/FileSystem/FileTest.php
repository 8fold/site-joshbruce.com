<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests;

use JoshBruce\SiteDynamic\Tests\LiveContentTestCase;

use JoshBruce\SiteDynamic\FileSystem\File;

use SplFileInfo;

final class FileTest extends LiveContentTestCase
{
    public static function mainCssFile(): File
    {
        return File::at(
            self::pathToContentPublic() . '/assets/css/main.min.css',
            self::pathToContentPublic(),
        );
    }

    /**
     * @test
     *
     * @group file
     * @group live-content
     */
    public function found(): void
    {
        $this->assertFalse(
            self::rootContentFile()->notFound()
        );

        $this->assertTrue(
            File::at(__DIR__ . self::invalidPath(), __DIR__)->notFound()
        );
    }

    /**
     * @test
     *
     * @group file
     * @group live-content
     */
    public function canonical_url(): void // phpcs:ignore
    {
        $this->assertSame(
            'http://test.joshbruce',
            self::rootContentFile()->canonicalUrl('http://test.joshbruce')
        );
    }

    /**
     * @test
     *
     * @group file
     * @group live-content
     */
    public function mimetype(): void
    {
        $this->assertSame('text/html', self::rootContentFile()->mimetype());

        $this->assertSame('text/css', self::mainCssFile()->mimetype());
    }

    /**
     * @test
     *
     * @group file
     * @group live-content
     */
    public function path(): void
    {
        $this->assertSame(
            self::mainCssFile()->path(),
            (new SplFileInfo(
                self::pathToContentPublic() . '/assets/css/main.min.css'
            ))->getRealpath()
        );

        $this->assertSame(
            '/assets/css/main.min.css',
            self::mainCssFile()->path(full: false)
        );

        $this->assertSame(
            '/assets/css',
            self::mainCssFile()->path(full: false, omitFilename: true)
        );
    }

    /**
     * @test
     *
     * @group file
     * @group live-content
     */
    public function mimetype_for_file(): void // phpcs:ignore
    {
        $start = hrtime(true);

        $mimetype = File::at(
            self::pathToContentPublic() . '/assets/css/main.min.css',
            self::pathToContentPublic()
        )->mimetype();

        $end = hrtime(true);

        $total = $end - $start;
        $ms    = $total / 1e+6;

        $this->assertLessThan(1, $ms);

        $start = hrtime(true);

        $mimetype = File::at(
            self::pathToContentPublic() . '/content.md',
            self::pathToContentPublic()
        )->mimetype();

        $end = hrtime(true);

        $total = $end - $start;
        $ms    = $total / 1e+6;

        $this->assertLessThan(0.01, $ms);
    }

    /**
     * @test
     *
     * @group file
     * @group live-content
     */
    public function mimetype_for_text(): void // phpcs:ignore
    {
        $start = hrtime(true);

        $mimetype = File::at(
            self::pathToContentPublic() . '/content.md',
            self::pathToContentPublic()
        )->mimetype();

        $end = hrtime(true);

        $total = $end - $start;
        $ms    = $total / 1e+6;

        $this->assertLessThan(0.01, $ms);
    }
}
