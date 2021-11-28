<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests;

use JoshBruce\SiteDynamic\Tests\LiveContentTestCase;

final class IndexTest extends LiveContentTestCase
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
        $this->assertCount(2, self::ini_set_matches());
    }

    /**
     * @test
     *
     * @group validate-setup
     * @group live-content
     */
    public function index_is_not_displaying_errors(): void
    {
        foreach (self::ini_set_matches() as $match) {
            $this->assertFalse(str_contains($match, '1'));
        }
    }
}
