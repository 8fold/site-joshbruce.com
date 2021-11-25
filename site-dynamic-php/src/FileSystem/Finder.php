<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

use Countable;
use IteratorAggregate;
use SplFileInfo;

use Symfony\Component\Finder\Finder as SymfonyFinder;

class Finder implements Countable, IteratorAggregate
{
    private const DRAFT_INDICATOR = '_';

    private const REDIRECT_INDICATOR = '~';

    private static Finder $finder;

    private SymfonyFinder $symFinder;

    private bool $files = true;

    public static function init(string $publicRoot): static
    {
        if (! isset(self::$finder)) {
            self::$finder = new static($publicRoot);
        }
        return self::$finder;
    }

    final private function __construct(private string $publicRoot)
    {
        $this->symFinder = (new SymfonyFinder())
            ->ignoreVCS(true)
            ->ignoreUnreadableDirs()
            ->ignoreDotFiles(true)
            ->ignoreVCSIgnored(true)
            ->notName('.gitignore')
            ->sortByName();
    }

    public function publishedContent(): Finder
    {
        $this->symFinder = clone $this->baseFinder()
            ->filter(fn($f) => $this->isPublished($f))
            ->name($this->contentFilename())
            ->files()
            ->in($this->publicRoot);

        return $this;
    }

    public function draftContent(): Finder
    {
        $this->symFinder = clone $this->baseFinder()
            ->filter(fn($f) => $this->isDraft($f))
            ->files()
            ->in($this->publicRoot);

        return $this;
    }

    public function redirectedContent(): Finder
    {
        $this->symFinder = clone $this->baseFinder()
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
        return str_contains(
            $fileInfo->getPathname(),
            self::REDIRECT_INDICATOR
        );
    }

    private function isDraft(SplFileInfo $fileInfo): bool
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
        if (! isset($this->symFinder)) {
            $this->publishedContent();
        }
        return $this->symFinder;
    }
}
