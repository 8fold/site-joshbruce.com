<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

use Countable;
use IteratorAggregate;
use SplFileInfo;

use Symfony\Component\Finder\Finder as SymfonyFinder;

/**
 * @implements IteratorAggregate<SymfonyFinder>
 */
class Finder implements Countable, IteratorAggregate
{
    private const DRAFT_INDICATOR = '_';

    private SymfonyFinder $symFinder;

    public static function init(
        string $contentPublic,
        string $contentFilename
    ): static {
        return new static($contentPublic, $contentFilename);
    }

    final private function __construct(
        private string $contentPublic,
        private string $contentFilename
    ) {
        $this->symFinder = (new SymfonyFinder())
            ->ignoreVCS(true)
            ->ignoreUnreadableDirs()
            ->ignoreDotFiles(true)
            ->notName('.gitignore')
            ->sortByName();
    }

    public function allFiles(): Finder
    {
        $this->symFinder = clone $this->getIterator()
            ->files()
            ->in($this->contentPublic);

        return $this;
    }

    public function publishedContent(): Finder
    {
        $this->symFinder = clone $this->getIterator()
            ->filter(fn($f) => $this->isPublished($f))
            ->name($this->contentFilename())
            ->files()
            ->in($this->contentPublic);

        return $this;
    }

    public function draftContent(): Finder
    {
        $this->symFinder = clone $this->getIterator()
            ->filter(fn($f) => $this->isDraft($f))
            ->files()
            ->in($this->contentPublic);

        return $this;
    }

    private function contentFilename(): string
    {
        return $this->contentFilename;
    }

    private function isPublished(SplFileInfo $fileInfo): bool
    {
        return ! $this->isDraft($fileInfo);
    }

    public function isDraft(SplFileInfo $fileInfo): bool
    {
        return str_contains($fileInfo->getPathname(), self::DRAFT_INDICATOR);
    }

    /**
     * Countable methods
     */
    public function count(): int
    {
        return iterator_count($this->getIterator());
    }

    /**
     * IteratorAggregate methods
     */
    public function getIterator(): SymfonyFinder
    {
        return $this->symFinder;
    }
}
