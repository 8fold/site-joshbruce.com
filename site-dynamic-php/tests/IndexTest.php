<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class IndexTest extends TestCase
{
    public static function pathToIndex(): string|false
    {
        $rPath = __DIR__ . '/../../site-dynamic-php/public/index.php';
        $file  = new SplFileInfo($rPath);
        return $file->getRealPath();
    }

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
     * @group index
     * @group live-content
     */
    public function index_exists(): void
    {
        $this->assertIsString(self::pathToIndex());
    }

    /**
     * @test
     *
     * @group index
     * @group live-content
     */
    public function index_has_ini_set(): void
    {
        $this->assertCount(2, self::ini_set_matches());
    }

    /**
     * @test
     *
     * @group index
     * @group live-content
     */
    public function index_is_not_displaying_errors(): void
    {
        foreach (self::ini_set_matches() as $match) {
            $this->assertFalse(str_contains($match, '1'));
        }
    }
}
