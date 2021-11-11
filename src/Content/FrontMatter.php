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
    private function __construct(private array $frontMatter = [])
    {
    }

    public function hasMember(string $member): bool
    {
        return array_key_exists($member, $this->frontMatter);
    }

    public function title(): string
    {
        if ($this->hasMember('title')) {
            return strval($this->frontMatter['title']);
        }
        return '';
    }

    /**
     * @return array<int, int[]>
     */
    public function data(): array
    {
        if ($this->hasMember('data')) {
            return $this->frontMatter['data'];
        }
        return [];
    }

    public function created(): int|false
    {
        if ($this->hasMember('created')) {
            return $this->frontMatter['created'];
        }
        return false;
    }

    public function moved(): int|false
    {
        if ($this->hasMember('moved')) {
            return $this->frontMatter['moved'];
        }
        return false;
    }

    public function updated(): int|false
    {
        if ($this->hasMember('updated')) {
            return $this->frontMatter['updated'];
        }
        return false;
    }

    public function original(): string
    {
        if ($this->hasMember('original')) {
            return strval($this->frontMatter['original']);
        }
        return '';
    }

    public function template(): string
    {
        if ($this->hasMember('template')) {
            return strval($this->frontMatter['template']);
        }
        return '';
    }
}
