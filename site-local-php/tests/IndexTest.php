<?php

declare(strict_types=1);

namespace JoshBruce\SiteLocal\Tests;

use JoshBruce\SiteLocal\Tests\TestContentTestCase;

final class IndexTest extends TestContentTestCase
{
    public static function indexFileContents(): string
    {
        return file_get_contents(self::pathToIndex());
    }

    public static function ini_set_matches(): array
    {
        $matches = [];
        preg_match_all('/ini_set\(.*\);/', self::indexFileContents(), $matches);
        return array_shift($matches);
    }

    /**
     * @test
     *
     * @group validate-setup
     * @group live-content
     */
    public function index_exists(): void
    {
        $this->assertIsString(self::pathToIndex());
    }

    /**
     * @test
     *
     * @group validate-setup
     * @group live-content
     */
    public function index_has_ini_set(): void
    {
        $this->assertCount(4, self::ini_set_matches());
    }

    /**
     * @test
     *
     * @group validate-setup
     * @group live-content
     */
    public function index_is_displaying_errors(): void
    {
        foreach (self::ini_set_matches() as $match) {
            if (
                str_contains($match, 'display_errors') or
                str_contains($match, 'display_startup_errors')
            ) {
                $this->assertTrue(str_contains($match, '1'));
            }
        }
    }
}
