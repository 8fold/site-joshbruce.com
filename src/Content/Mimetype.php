<?php

declare(strict_types=1);

namespace JoshBruce\Site\Content;

class Mimetype
{
    private string $rawMimetype = '';

    /**
     * Converted to account for custom mimetype responses.
     */
    private string $mimetype = '';

    public static function for(string $path): Mimetype
    {
        return new Mimetype($path);
    }

    private function __construct(private string $path)
    {
    }

    private function isNotHtml(): bool
    {
        return $this->name() !== 'html';
    }

    public function isNotXml(): bool
    {
        return $this->name() !== 'xml' and $this->isNotHtml();
    }

    public function type(): string
    {
        if (strlen($this->mimetype) === 0) {
            $type = $this->rawMimetype();
            if ($type === 'text/plain') {
                $extensionMap = [
                    'md'  => 'text/html',
                    'css' => 'text/css',
                    'js'  => 'text/javascript',
                    'xml' => 'application/xml',
                    'txt' => 'text/plain',
                    'htaccess' => 'text/plain'
                ];

                $parts     = explode('.', $this->path);
                $extension = array_pop($parts);

                $type = $extensionMap[$extension];
            }

            $this->mimetype = $type;
        }
        return $this->mimetype;
    }

    private function rawMimetype(): string
    {
        if (strlen($this->rawMimetype) === 0) {
            $raw = mime_content_type($this->path);
            if (is_string($raw)) {
                $this->rawMimetype = $raw;
            }
        }
        return $this->rawMimetype;
    }

    private function name(): string
    {
        $parts = explode('/', $this->type());
        $name  = array_pop($parts);
        if (empty($name)) {
            return '';
        }
        return $name;
    }
}
