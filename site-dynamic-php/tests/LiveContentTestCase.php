<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests;

use PHPUnit\Framework\TestCase;

use SplFileInfo;

use JoshBruce\SiteDynamic\FileSystem\File;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

abstract class LiveContentTestCase extends TestCase
{
    public static function pathToContentPublic(): string
    {
        return __DIR__ . '/../../content/public';
    }

    public static function rootContentFile(): PlainTextFile
    {
        return PlainTextFile::at(
            self::pathToContentPublic() . '/content.md',
            self::pathToContentPublic(),
        );
    }

    public static function pathToIndexRelative(): string
    {
        return __DIR__ . '/../public/index.php';
    }

    public static function pathToIndex(): string|false
    {
        $file  = new SplFileInfo(self::pathToIndexRelative());
        return $file->getRealPath();
    }

    public static function invalidPath(): string
    {
        return '/does/not/ex/ist';
    }
}
