<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use DirectoryIterator;

use JoshBruce\Site\Content\FrontMatter;

/**
 * @todo: Change contentRoot to be the folder in which the text-based content is.
 */
class FileSystem
{
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

    /**
     * @return string Path to where the text-based content for the site lives.
     */
    public function contentRoot(): string
    {
        return $this->contentRoot;
    }

    public function with(string $folderPath, string $fileName = ''): FileSystem
    {
        return new self($this->contentRoot, $folderPath, $fileName);
    }

    public function fileNamed(string $fileName): FileSystem
    {
        return $this->with($this->folderPath, $fileName);
    }

    public function fileName(): string
    {
        return $this->fileName;
    }

    public function path(bool $full = true): string
    {
        $path = $this->contentRoot . $this->folderPath . '/' . $this->fileName();
        if (! $full) {
            $path = str_replace($this->contentRoot, '', $path);
        }

        if (str_ends_with($path, '/')) {
            return substr($path, 0, -1);
        }
        return $path;
    }

    public function mimetype(): string
    {
        $type = mime_content_type($this->path());
        if (is_bool($type) and $type === false) {
            return '';
        }

        if ($type === 'text/plain') {
            $extensionMap = [
                'md'  => 'text/html',
                'css' => 'text/css',
                'js'  => 'text/javascript'
            ];

            $parts     = explode('.', $this->path());
            $extension = array_pop($parts);

            $type = $extensionMap[$extension];
        }
        return $type;
    }

    public function navigation(string $file = ''): FileSystem
    {
        return $this->up()->with('/navigation', $file);
    }

    public function messages(string $file = ''): FileSystem
    {
        return $this->up()->with('/messages', $file);
    }

    public function media(string $file = ''): FileSystem
    {
        return $this->up()->with('/media', $file);
    }

    public function assets(string $file = ''): FileSystem
    {
        return $this->up()->with('/assets', $file);
    }

    public function rootFolderIsMissing(): bool
    {
        if (! file_exists($this->contentRoot())) {
            return true;
        }
        return ! is_dir($this->contentRoot());
    }

    public function notFound(): bool
    {
        return ! $this->found();
    }

    public function found(): bool
    {
        return file_exists($this->path());
    }

    public function isNotRoot(): bool
    {
        return ! $this->isRoot();
    }

    public function isRoot(): bool
    {
        $subtract = str_replace(
            [$this->contentRoot(), '/content.md'],
            ['', ''],
            $this->path()
        );
        return strlen($subtract) === 0 or $subtract === '/';
    }

    public function isFile(): bool
    {
        return file_exists($this->path()) and ! is_dir($this->path());
    }

    /**
     * @return FileSystem[]
     */
    public function folderStack(string $fileName = ''): array
    {
        $folderPath = $this->path();
        if (! is_dir($folderPath)) {
            return [];
        }
        $folderPath = str_replace($this->contentRoot(), '', $folderPath);

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

    /**
     * @return array<string, FileSystem>
     */
    public function subfolders(string $fileName = ''): array
    {
        $folderPath = $this->path();
        if (! is_dir($folderPath) and ! is_file($folderPath)) {
            return [];

        } elseif (is_file($folderPath)) {
            $parts = explode('/', $folderPath);
            array_pop($parts);
            $folderPath = implode('/', $parts);

        }

        $content = [];
        foreach (new DirectoryIterator($folderPath) as $folder) {
            if ($folder->isFile() or $folder->isDot()) {
                continue;
            }

            $fullPathToFolder = $folder->getPathname();
            $partialPath      = str_replace(
                $this->contentRoot(),
                '',
                $fullPathToFolder
            );

            $parts = explode('/', $partialPath);

            $folderName = array_pop($parts);

            $clone = clone $this;
            $content[$folderName] = $clone->with($partialPath, $fileName);
        }
        return $content;
    }

    private function up(): FileSystem
    {
        $parts = explode('/', $this->contentRoot);
        array_pop($parts);
        $newRoot = implode('/', $parts);
        return FileSystem::init($newRoot);
    }
}
