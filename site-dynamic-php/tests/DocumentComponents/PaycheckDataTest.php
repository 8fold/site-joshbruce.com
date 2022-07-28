<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests\DocumentComponents;

use JoshBruce\SiteDynamic\Tests\LiveContentTestCase;

use JoshBruce\SiteDynamic\DocumentComponents\Data;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use SplFileInfo;

final class PaycheckDataTest extends LiveContentTestCase
{
    /**
     * @test
     */
    public function data_returns_expected_html_for_1_1(): void // phpcs:ignore
    {
        $expected = file_get_contents(__DIR__ . '/data-1.0-expected.html');

        $data = PlainTextFile::at(__DIR__ . '/data-1.1.md', __DIR__);
        $result = Data::create($data) . "\n";

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function data_returns_expected_html_for_1_0(): void // phpcs:ignore
    {
        $expected = file_get_contents(__DIR__ . '/data-1.0-expected.html');

        $data = PlainTextFile::at(__DIR__ . '/data-1.0.md', __DIR__);
        $result = Data::create($data) . "\n";

        $this->assertSame($expected, $result);
    }
}
