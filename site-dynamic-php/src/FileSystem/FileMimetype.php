<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

class FileMimetype
{
    private string $mimetype = '';

    public static function with(string $raw, string $extension): static
    {
        return new static($raw, $extension);
    }

    final private function __construct(
        private string $raw,
        private string $extension
    ) {
    }

    public function category(): string
    {
        $parts = explode('/', $this->interpreted());
        $cat   = array_shift($parts);
        if (is_string($cat)) {
            return $cat;
        }
        return '';
    }

    public function name(): string
    {
        $parts = explode('/', $this->interpreted());
        $name  = array_pop($parts);
        if (is_string($name)) {
            return $name;
        }
        return '';
    }

    public function interpreted(): string
    {
        if (strlen($this->mimetype) === 0) {
            $this->mimetype = $this->raw();
            if ($this->mimetype === 'text/plain') {
                $this->mimetype = match($this->extension) {
                    'md'    => 'text/html',
                    'css'   => 'text/css',
                    'js'    => 'text/javascript',
                    'xml'   => 'application/xml',
                    default => 'text/plain'
                };
            }
        }
        return $this->mimetype;
    }

    public function raw(): string
    {
        return $this->raw;
    }
}