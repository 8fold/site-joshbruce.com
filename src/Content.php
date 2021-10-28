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
     * @var array<string, mixed>
     */
    private array $frontMatter = [];

    public static function init(
        string $projectRoot,
        int $contentUp,
        string $contentFolder
    ): Content {
        return new Content(
            $projectRoot,
            $contentUp,
            $contentFolder
        );
    }

    public function __construct(
        private string $projectRoot,
        private int $contentUp,
        private string $contentFolder
    ) {
    }

    public function folderIsMissing(): bool
    {
        return ! $this->folderExists();
    }

    public function for(string $path): Content
    {
        $this->path = $path;

        // reset cached values
        $this->markdown = '';
        $this->frontMatter = [];

        return $this;
    }

    public function notFound(): bool
    {
        return ! $this->exists();
    }

    public function hasMoved(): bool
    {
        return strlen($this->redirectPath()) > 0;
    }

    public function filePath(): string
    {
        return $this->root() . $this->path;
    }

    public function mimetype(): string
    {
        $type = mime_content_type($this->filePath());
        if (is_bool($type) and $type === false) {
            return '';
        }

        if ($type === 'text/plain') {
            $extensionMap = [
                'md'  => 'text/html',
                'css' => 'text/css',
                'js'  => 'text/javascript'
            ];

            $parts     = explode('.', $this->filePath());
            $extension = array_pop($parts);

            $type = $extensionMap[$extension];
        }
        return $type;
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

    public function markdown(): string
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

    private function folderExists(): bool
    {
        return file_exists($this->root()) and is_dir($this->root());
    }

    private function exists(): bool
    {
        return file_exists($this->filePath());
    }

    private function root(): string
    {
        if (strlen($this->root) === 0) {
            $contentParts = explode('/', $this->projectRoot);
            $contentUp    = $this->contentUp;

            if (is_int($contentUp) and $contentUp > 0) {
                $contentParts = array_slice($contentParts, 0, -1 * $contentUp);
            }
            $contentFolder = explode('/', $this->contentFolder);
            $contentFolder = array_filter($contentFolder);
            $contentParts  = array_merge($contentParts, $contentFolder);

            $this->root = implode('/', $contentParts);
        }
        return $this->root;
    }
}
