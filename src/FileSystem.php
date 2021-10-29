<?php

declare(strict_types=1);

namespace JoshBruce\Site;

class FileSystem
{
    private string $root = '';

    private string $path = '/';

    private string $fileName = '';

    // private string $markdown = '';

    /**
     * @var array<string, mixed>
     */
    private array $frontMatter = [];

    public static function init(
        string $projectRoot,
        int $contentUp,
        string $contentFolder
    ): FileSystem {
        return new FileSystem(
            $projectRoot,
            $contentUp,
            $contentFolder
        );
    }

    public function with(string $path): FileSystem
    {
        $parts = explode('/', $path);
        $possibleFileName = array_pop($parts);
        if (strpos($possibleFileName, '.') > 0) {
            $this->fileName = $possibleFileName;
            $path = implode('/', $parts);
        }
        $this->path = $path;
        return $this;
    }

    public function __construct(
        private string $projectRoot,
        private int $contentUp,
        private string $contentFolder
    ) {
    }

    public function filePath(): string
    {
        if (strlen($this->fileName) === 0) {
            return $this->root() . $this->path;
        }
        return $this->root() . $this->path . '/' . $this->fileName;
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

    private function rootFolderExists(): bool
    {
        return file_exists($this->root()) and is_dir($this->root());
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
