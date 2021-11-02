<?php

declare(strict_types=1);

namespace JoshBruce\Site\Content;

class FrontMatter
{
    /**
     * @param array<string, mixed> $frontMatter
     */
    public static function init(array $frontMatter = []): FrontMatter
    {
        return new FrontMatter($frontMatter);
    }

    /**
     * @param array<string, mixed> $frontMatter
     */
    public function __construct(private array $frontMatter = [])
    {
    }

    public function hasMember(string $member): bool
    {
        return array_key_exists($member, $this->frontMatter);
    }

    public function title(): string
    {
        if ($this->hasMember('title')) {
            return $this->frontMatter['title'];
        }
        return '';
    }

    /**
     * @return array<int, string>
     */
    public function navigation(): array
    {
        if ($this->hasMember('navigation')) {
            return $this->frontMatter['navigation'];
        }
        return [];
    }

    public function redirectPath(): string
    {
        if ($this->hasMember('redirect')) {
            return $this->frontMatter['redirect'];
        }
        return '';
    }
}
