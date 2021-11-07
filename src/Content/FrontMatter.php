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
     * @return array<int, string>
     */
    public function dateblock(): array
    {
        if ($this->hasMember('dateblock')) {
            return $this->frontMatter['dateblock'];
        }
        return [];
    }
//
//     public function header(): string
//     {
//         if ($this->hasMember('header')) {
//             return strval($this->frontMatter['header']);
//         }
//         return '';
//     }
//
//     /**
//      * @return array<int, string>
//      */
//     public function navigation(): array
//     {
//         if ($this->hasMember('navigation')) {
//             return $this->frontMatter['navigation'];
//         }
//         return [];
//     }
//
//     public function redirectPath(): string
//     {
//         if ($this->hasMember('redirect')) {
//             return strval($this->frontMatter['redirect']);
//         }
//         return '';
//     }
//
//     /**
//      * @return array<int, int[]>
//      */
//     public function data(): array
//     {
//         if ($this->hasMember('data')) {
//             return $this->frontMatter['data'];
//         }
//         return [];
//     }
//
//     public function original(): string
//     {
//         if ($this->hasMember('original')) {
//             return strval($this->frontMatter['original']);
//         }
//         return '';
//     }
//
//     public function type(): string
//     {
//         if ($this->hasMember('type')) {
//             return strval($this->frontMatter['type']);
//         }
//         return '';
//     }
//
//     public function created(): int|false
//     {
//         if ($this->hasMember('created')) {
//             return intval($this->frontMatter['created']);
//         }
//         return false;
//     }
//
//     public function updated(): int|false
//     {
//         if ($this->hasMember('updated')) {
//             return intval($this->frontMatter['updated']);
//         }
//         return false;
//     }
//
//     public function moved(): int|false
//     {
//         if ($this->hasMember('moved')) {
//             return intval($this->frontMatter['moved']);
//         }
//         return false;
//     }
}
