<?php

declare(strict_types=1);

namespace JoshBruce\Site\Content;

use DirectoryIterator;

use Eightfold\Markdown\Markdown as MarkdownConverter;

use JoshBruce\Site\FileSystem;

use JoshBruce\Site\Content\FrontMatter;

class Markdown
{
    private string $markdown = '';

    /**
     * @var FrontMatter
     */
    private FrontMatter $frontMatter;

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

    public function frontMatter(): FrontMatter
    {
        if (! isset($this->frontMatter)) {
            $markdown = '';
            if (strlen($this->markdown) === 0) {
                $markdown = $this->markdown();
            }

            $frontMatter = MarkdownConverter::create()
                ->getFrontMatter($markdown);

            $this->frontMatter = FrontMatter::init($frontMatter);
        }
        return $this->frontMatter;
    }

    public function hasMoved(): bool
    {
        return strlen($this->redirectPath()) > 0;
    }

    public function redirectPath(): string
    {
        return $this->frontMatter()->redirectPath();
    }
}
