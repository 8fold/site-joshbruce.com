<?php

declare(strict_types=1);

namespace JoshBruce\Site;

// use DirectoryIterator;

// use JoshBruce\Site\Content\FrontMatter;

class File
{
    public static function init(string $path): File
    {
        return new File($path);
    }

    final public function __construct(private string $path)
    {}

    public function path(bool $full = true): string
    {
        if ($full) {
            return $this->path;
        }

        $dir     = __DIR__;
        $parts   = explode('/', $dir);
        $parts   = array_slice($parts, 0, -1);
        $parts[] = 'content';
        $path    = implode('/', $parts);

        return str_replace($path, '', $this->path);
    }

    public function fileName(): string
    {
        $path  = $this->path();
        $parts = explode('/', $path);
        return array_pop($parts);
    }

    public function contents(): string
    {
        return file_get_contents($this->path());
    }

    public function found(): bool
    {
        return file_exists($this->path()) and is_file($this->path());
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
}
