<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

use JoshBruce\SiteDynamic\FileSystem\FileMimetype;

interface FileInterface
{
    public static function at(string $localPath, string $root): FileInterface;

    public function mimetype(): FileMimetype;
}
