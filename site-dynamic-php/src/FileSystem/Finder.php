<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

use Countable;
use IteratorAggregate;
use SplFileInfo;

// use Psr\Http\Message\RequestInterface;

use Symfony\Component\Finder\Finder as SymfonyFinder;

use JoshBruce\SiteDynamic\Http\Request;
use JoshBruce\SiteDynamic\FileSystem\File;

/**
 * Singleton
 *
 * Essentially a File factory. No matter the status code for the Response,
 * a File will be returned for the Response.
 */
class Finder implements Countable, IteratorAggregate
{
    private const DRAFT_INDICATOR = '_';

    private const REDIRECT_INDICATOR = '~';

    private const CONTENT_FOLDER_NAME = 'content';

    private const CONTENT_FILENAME = 'content.md';

    private const FILE_SEPARATOR = '/';

    private const ENV_REQUIRED = [
        'APP_ENV',
        'APP_URL'
    ];

    private const SUPPORTED_METHODS = [
      'GET'
    ];

    private static Finder $finder;

    protected static string $projectRoot;

    protected static string $contentRoot;

    private SymfonyFinder $symFinder;

    private bool $files = true;

    public static function init(): static
    {
        if (! isset(self::$finder)) {
            self::$finder = new static();
        }
        return self::$finder;
    }

    protected static function projectRoot(): string
    {
        if (! isset(static::$projectRoot)) {
            $dir   = __DIR__;
            $parts = explode(self::FILE_SEPARATOR, $dir);
            $parts = array_slice($parts, 0, -3);
            static::$projectRoot = implode(self::FILE_SEPARATOR, $parts);

        }
        return static::$projectRoot;
    }

    private static function contentRoot(): string
    {
        if (! isset(self::$contentRoot)) {
            $parts   = explode(self::FILE_SEPARATOR, static::projectRoot());
            $parts[] = self::CONTENT_FOLDER_NAME;

            $base = implode(self::FILE_SEPARATOR, $parts);
            if (str_ends_with($base, self::FILE_SEPARATOR)) {
                $base = substr($base, 0, -1);
            }

            self::$contentRoot = $base;
        }
        return self::$contentRoot;
    }

    private static function publicRoot(): string
    {
        return self::contentRoot() . '/public';
    }

    public static function isMissingRequiredFolders(): bool
    {
        return ! self::hasRequiredFolders();
    }

    private static function hasRequiredFolders(): bool
    {
        return self::hasFolder(self::projectRoot()) and
            self::hasFolder(self::contentRoot()) and
            self::hasFolder(self::publicRoot());
    }

    private static function hasFileForRequest(Request $request): bool
    {
        return self::hasFile(
            self::filePathForRequest($request)
        );
    }

    public static function isMissingFileForRequest(Request $request): bool
    {
        return ! self::hasFileForRequest($request);
    }

    private static function hasFile(string $path): bool
    {
        return file_exists($path) and is_file($path);
    }

    private static function hasFolder(string $path): bool
    {
        return file_exists($path) and is_dir($path);
    }

    public static function filePathForRequest(Request $request): string
    {
        $path = self::publicRoot() . $request->getUri()->getPath();
        if ($request->isRequestingContent()) {
            $path .= '/content.md';

        }
        $path = str_replace('//', '/', $path);
        return $path;
    }

    public static function isMisconfiguredEnvironment(): bool
    {
        foreach (self::ENV_REQUIRED as $key) {
            if (! array_key_exists($key, $_SERVER)) {
                return true;
            }
        }
        return false;
    }

    public static function isUnsupportedMethod(Request $request): bool
    {
        $requestMethod = strtoupper($request->getMethod());
        return ! in_array($requestMethod, self::SUPPORTED_METHODS);
    }

    public static function fileForRequest(Request $request): File
    {
//         if (
//             self::isMisconfiguredEnvironment() or
//             self::isMissingRequiredFolders()
//         ) {
//             die('returning file with 500 status');
//
//         } elseif (self::isUnsupportedMethod($request)) {
//             die('returning file with 405 status');
//
//         } elseif (self::isMissingFileForRequest($request)) {
//             die('returning file with 404 status');
//
//         }

        // at this point we can build a file
        $path = self::filePathForRequest($request);
        $file = File::at($path, self::publicRoot());
        if ($redirect = $file->redirect()) {
            // file will only have headers and empty body
        }
        return $file;
    }

    final private function __construct()
    {
    }

//     public function publicFileForRequest(
//         Request $request,
//         string $publicRoot,
//         int $statusCode
//     ): File {
//         // $root = $request->finder()->publicRoot();
//         $path = $request->getUri()->getPath();
//         if (! str_starts_with($path, '/')) {
//             $path = '/' . $path;
//         }
//
//         $filename = '';
//         if ($request->isRequestingContent()) {
//             $filename = '/' . self::CONTENT_FILENAME;
//         }
//
//         $localPath = $publicRoot . $path . $filename;
//         if (str_contains($localPath, '//')) {
//             $localPath = str_replace('//', '/', $localPath);
//         }
//         return File::at($localPath, $publicRoot);
//     }

    // public function isMissingRequiredFolders(): bool
    // {
    //     return ! $this->hasRequiredFolders();
    // }

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

//     private function contentRoot(): string
//     {
//         if (strlen($this->contentRoot) === 0) {
//             $parts   = explode(self::FILE_SEPARATOR, static::projectRoot());
//             $parts[] = self::CONTENT_FOLDER_NAME;
//
//             $base = implode(self::FILE_SEPARATOR, $parts);
//             if (str_ends_with($base, self::FILE_SEPARATOR)) {
//                 $base = substr($base, 0, -1);
//             }
//
//             $this->contentRoot = $base;
//         }
//         return $this->contentRoot;
//     }

    // public function publicRoot(): string
    // {
    //     return $this->contentRoot() . '/public';
    // }

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
