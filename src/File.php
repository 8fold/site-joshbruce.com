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

    public function path(): string
    {
        return $this->path;
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
}
