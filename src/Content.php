<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Eightfold\Markdown\Markdown;

use JoshBruce\Site;

class Content
{
    private string $root = '';

    private string $path = '/';

    private string $markdown = '';

    /**
     * @var array<string, int|string|array>
     */
    private array $frontMatter = [];

    public static function init(
        string $projectRoot,
        int $contentUp,
        string $contentFolder,
        Markdown $markdownConverter
    ): Content {
        return new Content(
            $projectRoot,
            $contentUp,
            $contentFolder,
            $markdownConverter
        );
    }

    public function __construct(
        private string $projectRoot,
        private int $contentUp,
        private string $contentFolder,
        private Markdown $markdownConverter
    ) {
    }

    public function for(string $path): Content
    {
        $this->path = $path;
        return $this;
    }

    public function exists(): bool
    {
        return file_exists($this->filePath());
    }

    public function path(): string
    {
        return $this->path;
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

            $this->frontMatter = $this->markdownConverter()
                ->getFrontMatter($markdown);
        }
        return $this->frontMatter;
    }

    public function title(): string
    {
        if ($this->exists()) {
            $fm = $this->frontMatter();
            $title = $fm['title'];
            if (is_string($title)) {
                return $title;
            }
        }
        return '';
    }

    public function html(): string
    {
        return $this->markdownConverter()->convert($this->markdown());
    }

    public function filePath(): string
    {
        return $this->root() . $this->path();
    }

    private function markdown(): string
    {
        if (strlen($this->markdown) === 0 and $this->exists()) {
            $markdown = file_get_contents($this->filePath());

            if (is_bool($markdown)) {
                $markdown = '';
            }

            $this->markdown = $markdown;
        }
        return $this->markdown;
    }

    private function markdownConverter(): Markdown
    {
        return $this->markdownConverter;
    }

    public function isValid(): bool
    {
        return file_exists($this->root()) and is_dir($this->root());
    }

    public function root(): string
    {
        if (strlen($this->root) === 0) {
            $contentStart = $this->projectRoot();

            $contentParts = explode('/', $contentStart);
            $contentUp    = $this->contentUp();

            if (is_int($contentUp) and $contentUp > 0) {
                $contentParts = array_slice($contentParts, 0, -1 * $contentUp);
            }
            $contentFolder = explode('/', $this->contentFolder());
            $contentFolder = array_filter($contentFolder);
            $contentParts  = array_merge($contentParts, $contentFolder);

            $this->root = implode('/', $contentParts);
        }
        return $this->root;
    }

    private function projectRoot(): string
    {
        return $this->projectRoot;
    }

    private function contentUp(): int
    {
        return $this->contentUp;
    }

    private function contentFolder(): string
    {
        return $this->contentFolder;
    }
}
