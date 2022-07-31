<?php
declare(strict_types=1);

namespace Eightfold\Amos;

use SplFileInfo;

use Eightfold\Amos\Markdown;
use Eightfold\Amos\Meta;

class Content
{
    private SplFileInfo $fileInfo;

    public static function init(string $path): self
    {
        return new self($path);
    }

    final private function __construct(private string $path)
    {
    }

    public function root(): string
    {
        $path = $this->fileInfo()->getRealPath();
        if ($path === false) {
            return '';
        }
        return $path;
    }

    public function publicContentRoot(): string
    {
        return $this->root() . '/public';
    }

    public function publicPath(string $at): string
    {
        if ($at === '/') {
            $at = '';
        }
        return $this->publicContentRoot() . $at;
    }

    public function metaPath(string $at): string
    {
        if ($at === '/') {
            $at = '';
        }
        return $this->publicPath($at) . '/meta.json';
    }

    public function meta(string $at): Meta
    {
        $json = file_get_contents($this->metaPath($at));
        return Meta::init($json, $this->publicPath($at));
    }

    public function contentPath(string $at): string
    {
        if ($at === '/') {
            $at = '';
        }
        return $this->publicPath($at) . '/content.md';
    }

    public function found(string $at): bool
    {
        return file_exists($this->publicPath($at));
    }

    public function notFound(string $at): bool
    {
        return ! $this->found($at);
    }

    public function markdown(string $at, bool $isContent = true): string
    {
        $content = ($isContent === false)
            ? file_get_contents($this->root() . $at)
            : file_get_contents($this->contentPath($at));

        if ($content === false) {
            return '';
        }
        return $content;
    }

    public function convertedContent(
        string $at,
        array $partials = [],
        Meta|bool $useMeta = false
    ): string {
        if ($useMeta) {
            return $this->convertMarkdown(
                $this->markdown($at),
                $partials,
                $this->meta($at)
            );
        }
        return $this->convertMarkdown($this->markdown($at), $partials);
    }

    public function convertMarkdown(
        string $markdown,
        array $partials = [],
        Meta|bool $meta = false
    ): string {
        if ($meta !== false) {
            return Markdown::convert($markdown, $partials, $meta);
        }
        return Markdown::convert($markdown, $partials);
    }

    private function fileInfo(): SplFileInfo
    {
        if (isset($this->fileInfo) === false) {
            $this->fileInfo = new SplFileInfo($this->path);
        }
        return $this->fileInfo;
    }
}
