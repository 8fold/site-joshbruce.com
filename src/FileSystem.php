<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use DirectoryIterator;

class FileSystem
{
    /**
     * @var array<string, mixed>
     */
    private array $frontMatter = [];

    public static function init(
        string $contentRoot,
        string $folderPath = '/',
        string $fileName = ''
    ): FileSystem {
        return new FileSystem(
            $contentRoot,
            $folderPath,
            $fileName
        );
    }

    public function __construct(
        private string $contentRoot,
        private string $folderPath = '/',
        private string $fileName = ''
    ) {
    }

    public function with(string $folderPath, string $fileName = ''): FileSystem
    {
        return new self($this->contentRoot, $folderPath, $fileName);
    }

    public function fileName(): string
    {
        return $this->fileName;
    }

    public function folderPath(bool $full = true): string
    {
        if ($full) {
            return $this->contentRoot . $this->folderPath;
        }
        return $this->folderPath;
    }

    public function notFound(): bool
    {
        return ! $this->found();
    }

    public function found(): bool
    {
        return file_exists($this->filePath());
    }

    public function rootFolderIsMissing(): bool
    {
        if (! file_exists($this->contentRoot)) {
            return true;
        }
        return ! is_dir($this->contentRoot);
    }

    public function isFile(): bool
    {
        return strlen($this->fileName()) > 0;
    }

    private function isNotFile(): bool
    {
        return ! $this->isFile();
    }

    public function filePath(): string
    {
        if ($this->isNotFile()) {
            return $this->folderPath() . '/content.md';
        }

        $folderMap = [
            '/css'    => '/.assets/styles',
            '/js'     => '/.assets/scripts',
            '/assets' => '/.assets'
        ];

        $path  = str_replace($this->contentRoot, '', $this->folderPath());
        $parts = explode('/', $path);
        $parts = array_filter($parts);
        $first = array_shift($parts);

        $folderMapKey  = '/' . $first;

        $path = $this->folderPath() . '/' . $this->fileName();
        if (array_key_exists($folderMapKey, $folderMap)) {
            $replace = $folderMap[$folderMapKey];
            $path = str_replace($folderMapKey, $replace, $path);

        }
        return $path;
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
     * @return array<string, FileSystem>
     */
    public function subfolders(string $fileName = ''): array
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
            $path       = str_replace(
                $this->contentRoot,
                '',
                $folder->getPathname()
            );
            $folderName = array_slice(explode('/', $path), -1); // up 1
            $folderName = array_shift($folderName);
            if ($folderName !== null) {
                $clone = clone $this;
                $content[$folderName] = $clone->with($path, $fileName);
            }
        }
        return $content;
    }

    /**
     * @return FileSystem[]
     */
    public function folderStack(string $fileName = ''): array
    {
        $folderPath = $this->folderPath();
        if (! is_dir($folderPath)) {
            return [];
        }
        $folderPath = str_replace($this->contentRoot, '', $folderPath);

        $folderPathParts = explode('/', $folderPath);

        $folders = [];
        while (count($folderPathParts) > 0) {
            $path = implode('/', $folderPathParts);

            $clone = clone $this;
            $clone = $clone->with(folderPath: $path, fileName: $fileName);

            $folders[] = $clone;

            array_pop($folderPathParts);
        }
        return $folders;
    }
}
