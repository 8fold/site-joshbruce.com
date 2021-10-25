<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use JoshBruce\Site\Environment;

class Content
{
    private string $root = '';

    public static function init(
        string $projectRoot,
        int $contentUp,
        string $contentFolder
    ): Content {
        return new Content($projectRoot, $contentUp, $contentFolder);
    }

    public function __construct(
        private string $projectRoot,
        private int $contentUp,
        private string $contentFolder
    ) {
    }

    public function isValid(): bool
    {
        return file_exists($this->root()) and is_dir($this->root());
    }

    public function root(): string
    {
        if (strlen($this->root) === 0) {
            $contentStart = $this->projectRoot();

            $contentParts = explode('/', $contentStart);
            $contentUp    = $this->contentUp();

            if (is_int($contentUp) and $contentUp > 0) {
                $contentParts = array_slice($contentParts, 0, -1 * $contentUp);
            }
            $contentFolder = explode('/', $this->contentFolder());
            $contentFolder = array_filter($contentFolder);
            $contentParts  = array_merge($contentParts, $contentFolder);

            $this->root = implode('/', $contentParts);
        }
        return $this->root;
    }

    private function projectRoot(): string
    {
        return $this->projectRoot;
    }

    private function contentUp(): int
    {
        return $this->contentUp;
    }

    private function contentFolder(): string
    {
        return $this->contentFolder;
    }
}
