<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

class Heading
{
    /**
     * @param array<string, mixed> $frontMatter
     */
    public static function create(array $frontMatter): string
    {
        if (array_key_exists('header', $frontMatter)) {
            return "# {$frontMatter['header']}";

        }
        return "# {$frontMatter['title']}";
    }
}
