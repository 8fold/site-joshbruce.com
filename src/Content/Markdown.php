<?php

declare(strict_types=1);

namespace JoshBruce\Site\Content;

use DirectoryIterator;

use Eightfold\Markdown\Markdown as MarkdownConverter;

use JoshBruce\Site\FileSystem;

class Markdown
{
    private string $markdown = '';

    /**
     * @var array<string, mixed>
     */
    private array $frontMatter = [];

    public static function init(FileSystem $file): Markdown
    {
        return new Markdown($file);
    }

    public function __construct(private FileSystem $file)
    {
    }

    public function markdown(): string
    {
        if (strlen($this->markdown) === 0 and $this->file->found()) {
            $markdown = file_get_contents($this->file->filePath());

            if (is_bool($markdown)) {
                $markdown = '';
            }

            $this->markdown = $markdown;
        }
        return $this->markdown;
    }

    /**
     * @return array<string, int|string|array>
     */
    public function frontMatter(): array
    {
        if (count($this->frontMatter) === 0) {
            $markdown = '';
            if (strlen($this->markdown) === 0) {
                $markdown = $this->markdown();
            }

            $this->frontMatter = MarkdownConverter::create()
                ->getFrontMatter($markdown);
        }
        return $this->frontMatter;
    }

    public function hasMoved(): bool
    {
        return strlen($this->redirectPath()) > 0;
    }

    public function redirectPath(): string
    {
        $fm = $this->frontMatter();
        if (
            array_key_exists('redirect', $fm) and
            $redirect = $fm['redirect'] and
            is_string($redirect)
        ) {
            return $redirect;
        }
        return '';
    }
}
