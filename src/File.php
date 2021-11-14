<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use DirectoryIterator;

use Symfony\Component\Yaml\Yaml;

use JoshBruce\Site\FileSystemInterface;
use JoshBruce\Site\ServerGlobals;

class File
{
    private string $contentFileName = '/content.md';

    private string $contents = '';

    private string $mimetype = '';

    public static function at(string $localPath, FileSystemInterface $in): File
    {
        return new File($localPath, $in);
    }

    private function __construct(
        private string $localPath,
        private FileSystemInterface $fileSystem
    ) {
    }

    public function title(): string|false
    {
        if ($this->isNotFound()) {
            // TODO: test
            return false;
        }

        $mimetype = mime_content_type($this->path());
        if ($mimetype !== 'text/plain') {
            // directories return type of `directory`
            // TODO: test
            return false;
        }

        $contents = file_get_contents($this->path());
        $parts    = explode('---', $contents);

        if (count($parts) === 0 or strlen($parts[0]) > 0) {
            //TODO: test
            return false;
        }

        $metadata = Yaml::parse($parts[1]);

        if (! array_key_exists('title', $metadata)) {
            return '';
        }
        return $metadata['title'];
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

    public function pageTitle(): string
    {
        $titles   = [];
        $titles[] = $this->title();

        $file = clone $this;
        while ($file->canGoUp()) {
            $file = $file->up();
            $titles[] = $file->title();
        }

        $titles = array_filter($titles);
        $titles = array_reverse($titles);
        return implode(' | ', $titles);
    }

    private function up(): File
    {
        $parts = explode('/', $this->localPath);
        $parts = array_slice($parts, 0, -2); // remove file name and one folder.
        $localPath = implode('/', $parts);
        return File::at(
            $localPath . $this->contentFileName,
            $this->fileSystem()
        );
    }

    private function canGoUp(): bool
    {
        return $this->path(false) !== $this->contentFileName;
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

    public function contents(): string
    {
        if (strlen($this->contents) === 0) {
            $contents = file_get_contents($this->path());
            if ($contents === false) {
                return '';
            }
            $this->contents = $contents;
        }
        return $this->contents;
    }

    public function mimetype(): string
    {
        if (strlen($this->mimetype) === 0) {
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
            $this->mimetype = $type;
        }
        return $this->mimetype;
    }

    public function canonicalUrl(): string
    {
        return str_replace(
            $this->contentFileName,
            '',
            ServerGlobals::init()->appUrl() . $this->path(false)
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
