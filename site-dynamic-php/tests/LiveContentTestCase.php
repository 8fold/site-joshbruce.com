<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests;

use PHPUnit\Framework\TestCase;

use SplFileInfo;

abstract class LiveContentTestCase extends TestCase
{
    public static function pathToIndexRelative(): string
    {
        return __DIR__ . '/../public/index.php';
    }

    public static function pathToIndex(): string|false
    {
        $file  = new SplFileInfo(self::pathToIndexRelative());
        return $file->getRealPath();
    }

}
