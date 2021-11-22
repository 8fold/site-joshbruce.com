<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

use Countable;
use IteratorAggregate;
use SplFileInfo;

use Psr\Http\Message\RequestInterface;

use Symfony\Component\Finder\Finder as SymfonyFinder;

use JoshBruce\SiteDynamic\FileSystem\File;

class Finder implements Countable, IteratorAggregate
{
    private const DRAFT_INDICATOR = '_';

    private const REDIRECT_INDICATOR = '~';

    private const CONTENT_FOLDER_NAME = 'content';

    private const CONTENT_FILENAME = 'content.md';

    private const FILE_SEPARATOR = '/';

    private static Finder $finder;

    private string $contentRoot = '';

    private SymfonyFinder $symFinder;

    private bool $files = true;

    public static function init(): static
    {
        self::$finder = new static(static::projectRoot());
        return self::$finder;
    }

    public static function projectRoot(): string
    {
        $dir   = __DIR__;
        $parts = explode(self::FILE_SEPARATOR, $dir);
        $parts = array_slice($parts, 0, -3);
        return implode(self::FILE_SEPARATOR, $parts);
    }

    final private function __construct(protected string $projectRoot)
    {
    }

    public function publicFileForRequest(
        RequestInterface $request,
        string $publicRoot
    ): File {
        // $root = $request->finder()->publicRoot();
        $path = $request->getUri()->getPath();
        if (! str_starts_with($path, '/')) {
            $path = '/' . $path;
        }

        $filename = '';
        if ($request->isRequestingContent()) {
            $filename = '/' . self::CONTENT_FILENAME;
        }

        $localPath = $publicRoot . $path . $filename;
        if (str_contains($localPath, '//')) {
            $localPath = str_replace('//', '/', $localPath);
        }
        return File::at($localPath, $publicRoot);
    }

    public function hasRequiredFolders(): bool
    {
        return file_exists($this->contentRoot()) and
            file_exists($this->publicRoot()) and
            is_dir($this->contentRoot()) and
            is_dir($this->publicRoot());
    }

    public function isMissingRequiredFolders(): bool
    {
        return ! $this->hasRequiredFolders();
    }

    public function publishedContent(): Finder
    {
        $this->symFinder = clone $this->baseFinder()
            ->filter(fn($f) => $this->isPublished($f))
            ->name(self::CONTENT_FILENAME)
            ->files()
            ->in($this->publicRoot());

        return $this;
    }

    public function draftContent(): Finder
    {
        $this->symFinder = clone $this->baseFinder()
            ->filter(fn($f) => $this->isDraft($f))
            ->files()
            ->in($this->publicRoot());

        return $this;
    }

    public function redirectedContent(): Finder
    {
        $this->symFinder = clone $this->baseFinder()
            ->filter(fn($f) => $this->isRedirected($f))
            ->files()
            ->in($this->publicRoot());

        return $this;
    }

    private function isPublished(SplFileInfo $fileInfo): bool
    {
        return ! $this->isDraft($fileInfo);
    }

    private function isDraft(SplFileInfo $fileInfo): bool
    {
        return str_contains($fileInfo->getPathname(), self::DRAFT_INDICATOR);
    }

    private function isRedirected(SplFileInfo $fileInfo): bool
    {
        return str_contains(
            $fileInfo->getPathname(),
            self::REDIRECT_INDICATOR
        );
    }

    private function contentRoot(): string
    {
        if (strlen($this->contentRoot) === 0) {
            $parts   = explode(self::FILE_SEPARATOR, static::projectRoot());
            $parts[] = self::CONTENT_FOLDER_NAME;

            $base = implode(self::FILE_SEPARATOR, $parts);
            if (str_ends_with($base, self::FILE_SEPARATOR)) {
                $base = substr($base, 0, -1);
            }

            $this->contentRoot = $base;
        }
        return $this->contentRoot;
    }

    public function publicRoot(): string
    {
        return $this->contentRoot() . '/public';
    }

    private function baseFinder(): SymfonyFinder
    {
        if (! isset($this->symFinder)) {
            $this->symFinder = (new SymfonyFinder())
                ->ignoreVCS(true)
                ->ignoreUnreadableDirs()
                ->ignoreDotFiles(true)
                ->ignoreVCSIgnored(true)
                ->notName('.gitignore')
                ->sortByName();
        }
        return $this->symFinder;
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
