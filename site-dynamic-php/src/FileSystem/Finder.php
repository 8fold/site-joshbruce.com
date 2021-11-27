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

    private const REDIRECT_INDICATOR = '~';

    private SymfonyFinder $symFinder;

    public static function init(string $publicRoot): static
    {
        return new static($publicRoot);
    }

    final private function __construct(private string $publicRoot)
    {
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
            ->in($this->publicRoot);

        return $this;
    }

    public function publishedContent(): Finder
    {
        $this->symFinder = clone $this->getIterator()
            ->filter(fn($f) => $this->isPublished($f))
            ->name($this->contentFilename())
            ->files()
            ->in($this->publicRoot);

        return $this;
    }

    public function draftContent(): Finder
    {
        $this->symFinder = clone $this->getIterator()
            ->filter(fn($f) => $this->isDraft($f))
            ->files()
            ->in($this->publicRoot);

        return $this;
    }

    public function redirectedContent(): Finder
    {
        $this->symFinder = clone $this->getIterator()
            ->filter(fn($f) => $this->isRedirected($f))
            ->files()
            ->in($this->publicRoot);

        return $this;
    }

    private function contentFilename(): string
    {
        return $_SERVER['CONTENT_FILENAME'];
    }

    private function isPublished(SplFileInfo $fileInfo): bool
    {
        return ! $this->isDraft($fileInfo);
    }

    private function isRedirected(SplFileInfo $fileInfo): bool
    {
        return str_contains($fileInfo->getPathname(), self::REDIRECT_INDICATOR);
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
