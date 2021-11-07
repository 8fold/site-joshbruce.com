<?php

declare(strict_types=1);

namespace JoshBruce\Site;
//
// // use DirectoryIterator;
//
// // use JoshBruce\Site\Content\FrontMatter;
//
use JoshBruce\Site\FileSystem;

class File
{
    public static function at(string $localPath): File
    {
        return new File($localPath);
    }

    private function __construct(private string $localPath)
    {
    }

    public function isNotMarkdown(): bool
    {
        return ! $this->isMarkdown();
    }

    private function isMarkdown(): bool
    {
        $parts = explode('/', $this->localPath);
        $possibleFileName = array_pop($parts);
        return str_ends_with($possibleFileName, '.md');
    }

    public function found(): bool
    {
        return file_exists($this->path()) and is_file($this->path());
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
            FileSystem::contentRoot() . '/public',
            '',
            $this->localPath
        );
    }

    public function canGoUp(): bool
    {
        return $this->path(false) !== '/content.md';
    }

    public function up(): File
    {
        $parts = explode('/', $this->localPath);
        $parts = array_slice($parts, 0, -2); // remove file name and one folder.
        $localPath = implode('/', $parts);
        return File::at($localPath . '/content.md');
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
                'js'  => 'text/javascript'
            ];

            $parts     = explode('.', $this->path());
            $extension = array_pop($parts);

            $type = $extensionMap[$extension];
        }
        return $type;
    }
//     public static function init(string $path): File
//     {
//         return new File($path);
//     }
//
//     final public function __construct(private string $path)
//     {
//     }
//

//
//     /**
//      * @todo: move to trait
//      */
//     public function base(): string
//     {
//         $dir     = __DIR__;
//         $parts   = explode('/', $dir);
//         $parts   = array_slice($parts, 0, -1);
//         $parts[] = 'content';
//         return implode('/', $parts);
//     }
//
//     public function fileName(): string
//     {
//         $path  = $this->path();
//         $parts = explode('/', $path);
//         return array_pop($parts);
//     }
//

//

//
}
