<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests;

use JoshBruce\SiteDynamic\Tests\LiveContentTestCase;

use JoshBruce\SiteDynamic\FileSystem\File;

use SplFileInfo;

final class FileTest extends LiveContentTestCase
{
	public static function rootContentFile(): File
	{
		return File::at(
			__DIR__ . '/../../../content/public/content.md',
			__DIR__ . '/../../../content/public',
		);
	}

	public static function mainCssFile(): File
	{
		return File::at(
			__DIR__ . '/../../../content/public/assets/css/main.min.css',
			__DIR__ . '/../../../content/public',
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
    public function canonical_url(): void
    {
		$this->assertSame(
			self::rootContentFile()->canonicalUrl('http://test.joshbruce'),
			'http://test.joshbruce'
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
		$this->assertSame(self::rootContentFile()->mimetype(), 'text/html');

		$this->assertSame(self::mainCssFile()->mimetype(), 'text/css');
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
				__DIR__ . '/../../../content/public/assets/css/main.min.css'
			))->getRealpath()
		);

		$this->assertSame(
			self::mainCssFile()->path(full: false),
			'/assets/css/main.min.css'
		);

		$this->assertSame(
			self::mainCssFile()->path(full: false, omitFilename: true),
			'/assets/css'
		);
    }
}
