<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use DirectoryIterator;

use JoshBruce\Site\FileSystemInterface;

class File
{
    private string $contentFileName = '/content.md';

    public static function at(string $localPath, FileSystemInterface $in): File
    {
        return new File($localPath, $in);
    }

    private function __construct(
        private string $localPath,
        private FileSystemInterface $fileSystem
    ) {
    }

    public function isNotMarkdown(): bool
    {
        return ! $this->isMarkdown();
    }

    public function isMarkdown(): bool
    {
        $parts = explode('/', $this->localPath);
        $possibleFileName = array_pop($parts);
        return str_ends_with($possibleFileName, '.md');
    }

    public function isHtml(): bool
    {
        $parts = explode('/', $this->localPath);
        $possibleFileName = array_pop($parts);
        return str_ends_with($possibleFileName, '.html');
    }

    public function found(): bool
    {
        return file_exists($this->path()) and is_file($this->path());
    }

    public function isNotFound(): bool
    {
        return ! $this->found();
    }

    /**
     * @todo: move to trait
     */
    public function path(bool $full = true): string
    {
        if ($full) {
            return $this->localPath;
        }
        // TODO: test and verify used - returning empty string not an option.
        return str_replace(
            $this->fileSystem()->publicRoot(),
            '',
            $this->localPath
        );
    }

    public function canGoUp(): bool
    {
        return $this->path(false) !== $this->contentFileName;
    }

    public function up(): File
    {
        $parts = explode('/', $this->localPath);
        $parts = array_slice($parts, 0, -2); // remove file name and one folder.
        $localPath = implode('/', $parts);
        return File::at(
            $localPath . $this->contentFileName,
            $this->fileSystem()
        );
    }

    public function contents(): string
    {
        $contents = file_get_contents($this->path());
        if ($contents === false) {
            return '';
        }
        return $contents;
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
                'js'  => 'text/javascript',
                'xml' => 'application/xml'
            ];

            $parts     = explode('.', $this->path());
            $extension = array_pop($parts);

            $type = $extensionMap[$extension];
        }
        return $type;
    }

    public function canonicalUrl(): string
    {
        return str_replace(
            $this->contentFileName,
            '',
            'https://joshbruce.com' . $this->path(false)
        );
    }

    /**
     * @return File[]
     */
    public function children(string $filesNamed): array
    {
        $base = str_replace($this->contentFileName, '', $this->path());

        $files = [];
        foreach (new DirectoryIterator($base) as $folder) {
            if ($folder->isFile() or $folder->isDot()) {
                continue;
            }

            $fullPathToFolder = $folder->getPathname();
            $parts            = explode('/', $fullPathToFolder);
            $folderName       = array_pop($parts);

            $files[$folderName] = File::at(
                $fullPathToFolder . '/' . $filesNamed,
                $this->fileSystem()
            );
        }
        return $files;
    }

    private function fileSystem(): FileSystemInterface
    {
        return $this->fileSystem;
    }
}
