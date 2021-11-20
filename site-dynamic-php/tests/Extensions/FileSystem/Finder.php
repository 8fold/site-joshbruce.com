<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests\Extensions\FileSystem;

use JoshBruce\SiteDynamic\FileSystem\Finder as LocalFinder;

class Finder extends LocalFinder
{
    public static function projectRoot(): string
    {
        $dir     = __DIR__;
        $parts   = explode('/', $dir);
        $parts   = array_slice($parts, 0, -2);
        $parts[] = 'test-content';
        return implode('/', $parts);
    }
}
