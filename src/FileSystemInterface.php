<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Symfony\Component\Finder\Finder;

interface FileSystemInterface
{
    public static function projectRoot(): string;

    public function contentRoot(): string;

    public function publicRoot(): string;

    public function publishedContentFinder(): Finder;
}
