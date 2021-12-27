<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests\DocumentComponents;

use JoshBruce\SiteDynamic\Tests\LiveContentTestCase;

use JoshBruce\SiteDynamic\DocumentComponents\DateBlock;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use SplFileInfo;

final class FileTest extends LiveContentTestCase
{
    /**
     * @test
     */
    public function date_block_uses_date_modified_schema(): void // phpcs:ignore
    {
        $expected = file_get_contents(__DIR__ . '/date-block-expected.html');

        $result = DateBlock::create(
            self::thisInternetBandwidthContentFile()
        ) . "\n";

        $this->assertSame($expected, $result);
    }
}
