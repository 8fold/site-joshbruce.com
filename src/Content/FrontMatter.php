<?php

declare(strict_types=1);

namespace JoshBruce\Site\Content;

use DateTime;
// use Carbon\Carbon;

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

    public function created(string $format = ''): string|int|false
    {
        return $this->dateField('created', $format);
    }

    public function moved(string $format = ''): string|int|false
    {
        return $this->dateField('moved', $format);
    }

    public function updated(string $format = ''): string|int|false
    {
        return $this->dateField('updated', $format);
    }

    private function dateField(
        string $key,
        string $format = ''
    ): string|int|false {
        if ($this->hasMember($key)) {
            $date = $this->frontMatter[$key];
            if (strlen($format) === 0) {
                return $date;

            }

            $date = DateTime::createFromFormat('Ymd', strval($date));
            if ($date) {
                return $date->format($format);

            }
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

    public function description(): string
    {
        if ($this->hasMember('description')) {
            return strval($this->frontMatter['description']);
        }
        return '';
    }
}
