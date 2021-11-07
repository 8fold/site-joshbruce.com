<?php

declare(strict_types=1);

namespace JoshBruce\Site;

class FileSystem
{
    public static function contentRoot(): string
    {
        $parts   = explode('/', self::projectRoot());
        $parts[] = 'content';
        $base    = implode('/', $parts);
        if (str_ends_with($base, '/')) {
            $base = substr($base, 0, -1);
        }
        return $base;
    }

    private static function projectRoot(): string
    {
        $dir   = __DIR__;
        $parts = explode('/', $dir);
        $parts = array_slice($parts, 0, -1);
        return implode('/', $parts);
    }
}
