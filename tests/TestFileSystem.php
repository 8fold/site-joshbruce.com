<?php

declare(strict_types=1);

namespace JoshBruce\Site\Tests;

use JoshBruce\Site\FileSystem;

class TestFileSystem extends FileSystem
{
    public static function projectRoot(): string
    {
        // TODO: We're not actually using the instance yet - make static functions
        //       into instance methods
        return __DIR__ . '/test-content';
    }
}
