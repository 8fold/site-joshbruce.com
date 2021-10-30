<?php

declare(strict_types=1);

namespace JoshBruce\Site;

class FileSystem
{
    private string $rootFolder = '';

    /**
     * @var array<string, mixed>
     */
    private array $frontMatter = [];

    public static function init(
        string $projectRoot,
        int $contentUp,
        string $contentFolder,
        string $path = '/',
        string $fileName = ''
    ): FileSystem {
        $projectParts = explode('/', $projectRoot);
        $relativeUp   = $contentUp;
        if (is_int($contentUp) and $contentUp > 0) {
            $relativeParts = array_slice($projectParts, 0, -1 * $relativeUp);
        }

        $contentParts = explode('/', $contentFolder); // allow for subfolders
        $contentParts = array_filter($contentParts); // remove empty values

        $contentParts = array_merge($projectParts, $contentParts);

        $copy             = $contentParts;
        $possibleFileName = array_pop($copy);
        // account for hidden files where the dot is first character
        $fileNameParts    = array_filter(explode('.',  $possibleFileName));
        if (count($fileNameParts) >= 2) {
            $fileName = $possibleFileName;
            array_pop($contentParts); // remove last to get content folder path
        }

        $contentRoot = implode('/', $contentParts);

        return new FileSystem(
            $contentRoot,
            $path,
            $fileName
        );
    }

    public function __construct(
        private string $contentRoot,
        private string $path = '/',
        private string $fileName = ''
    ) {
    }

    public function with(string $path, string $fileName = ''): FileSystem
    {
        return new self($this->contentRoot, $path, $fileName);
    }

    public function path(): string
    {
        return $this->path;
    }

    public function fileName(): string
    {
        return $this->fileName;
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

    public function filePath(): string
    {
        if ($this->isFile()) {
            return $this->folderPath() . '/' . $this->fileName;
        }
        return $this->folderPath();
    }

    public function folderPath(): string
    {
        return $this->contentRoot . $this->path;
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
     * @return FileSystem[]
     */
    public function folderStack(): array
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
            $clone = $clone->with(path: $path);

            $folders[] = $clone;

            array_pop($folderPathParts);
        }
        return $folders;
    }
}
