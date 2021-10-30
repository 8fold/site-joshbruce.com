<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use DirectoryIterator;

use Eightfold\Markdown\Markdown;

use JoshBruce\Site\FileSystem;

class Content
{
    private string $markdown = '';

    /**
     * @var array<string, mixed>
     */
    private array $frontMatter = [];

    public static function init(FileSystem $file): Content
    {
        return new Content($file);
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

            $this->frontMatter = Markdown::create()->getFrontMatter($markdown);
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

    /**
     * @return array<string, Content>
     */
    public function contentInSubfolders(): array
    {
        $folderPath = $this->folderPath();
        if (! is_dir($folderPath)) {
            return [];
        }

        $content = [];
        foreach (new DirectoryIterator($folderPath) as $folder) {
            if ($folder->isFile() or $folder->isDot()) {
                // I feel continue should be named next or something.
                continue;
            }
            $path       = str_replace($this->root(), '', $folder->getPathname());
            $folderName = array_slice(explode('/', $path), -1);
            $folderName = array_shift($folderName);
            if ($folderName !== null) {
                $clone = clone $this;
                $content[$folderName] = $clone->for($path . '/content.md');
            }
        }
        return $content;
    }
}
