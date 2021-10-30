<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use DirectoryIterator;

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
        if (is_int($contentUp) and $contentUp > 0) {
            $projectParts = array_slice($projectParts, 0, -1 * $contentUp);
        }

        $contentParts = explode('/', $contentFolder); // allow for subfolders
        $contentParts = array_filter($contentParts); // remove empty values
        $contentParts = array_merge($projectParts, $contentParts);

        if (strlen($fileName) === 0) {
            $fileName = self::fileNameFromPath($contentParts);
        }

        $contentRoot = implode('/', $contentParts);

        return new FileSystem(
            $contentRoot,
            $path,
            $fileName
        );
    }

    /**
     * @param string|array<int, string> $path
     */
    public static function fileNameFromPath(array|string $path): string
    {
        if (is_string($path)) {
            $path = explode('/', $path);
        }

        $possibleFileName = array_pop($path);
        if ($possibleFileName !== null) {
            // account for hidden files where the dot is first character
            $fileNameParts = array_filter(explode('.', $possibleFileName));
            if (count($fileNameParts) === 1) {
                return $possibleFileName;
            }
        }
        return '';
    }

    public function __construct(
        private string $contentRoot,
        private string $path = '/',
        private string $fileName = ''
    ) {
    }

    public function with(string $path, string $fileName = ''): FileSystem
    {
        if (strlen($fileName) === 0) {
            $contentParts = explode('/', $path);
            $fileName = self::fileNameFromPath($contentParts);
        }

//         if ($f = self::fileNameFromPath($path) and strlen($f) > 0) {
//             $fileName = $f;
//
//             $parts = explode('/', $path);
//             array_pop($parts);
//             $path = implode('/', $parts);
//         }
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
     * @return array<string, FileSystem>
     * @todo Ability to specify file
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
     * @todo Ability to specify file
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
            $clone = $clone->with(path: $path, fileName: $fileName);

            $folders[] = $clone;

            array_pop($folderPathParts);
        }
        return $folders;
    }
}
