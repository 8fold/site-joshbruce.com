<?php

declare(strict_types=1);

namespace JoshBruce\Site\SiteStatic;

use SplFileInfo;

use Dotenv\Dotenv;

use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Finder\Finder;

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem as LeagueFilesystem;

use JoshBruce\Site\FileSystem;

use JoshBruce\Site\HttpResponse;
use JoshBruce\Site\HttpRequest;

class Generator
{
    private bool $isNotTesting = false;

    public static function init(
        OutputInterface $output,
        string $destination = ''
    ): Generator {
        return new Generator($output, $destination);
    }

    private function __construct(
        private OutputInterface $output,
        private string $destination = ''
    ) {
        $projectRoot = FileSystem::projectRoot();

        Dotenv::createImmutable($projectRoot)->load();

        if (isset($_SERVER['APP_ENV'])) {
            $this->isNotTesting = $_SERVER['APP_ENV'] !== 'testing';
        }

        $this->contentRoot = FileSystem::contentRoot() . '/public';

        if (strlen($destination) === 0) {
            $this->destination =  $projectRoot . '/site-static-html/public';
        }
    }

    public function compile(): bool
    {
        $this->compilingDidStartMessage($this->contentRoot, $this->destination);

        $finder = $this->finder();
        foreach ($finder as $found) {
            $path = (string) $found;

            if (str_contains($path, '.md')) {
                $this->compileContentFileFor($path);

            } else {
                $this->copyFileFor($path);

            }
        }
        return true;
    }

    private function compileContentFileFor(string $contentPath): void
    {
        $destinationPath = $this->contentDestinationPathFor($contentPath);

        $relativePath = $this->relativePath($contentPath);
        $parts        = explode('/', $relativePath);
        $parts        = array_slice($parts, 0, -1);
        $requestUri   = implode('/', $parts);

        $_SERVER['REQUEST_URI'] = (strlen($requestUri) === 0)
            ? '/'
            : $requestUri;

        $html = HttpResponse::from(request: HttpRequest::fromGlobals())->body();

        $this->leagueFileSystem()->write($destinationPath, $html);

        $this->sourceFileConvertedMessage($contentPath, $destinationPath);
    }

    private function copyFileFor(string $path): void
    {
        $destinationPath = $this->fileDestinationPathFor($path);
        $this->leagueFileSystem()->copy($path, $destinationPath);
        $this->sourceFileCopiedMessage($path, $destinationPath);
    }

    private function contentDestinationPathFor(string $path): string
    {
        return str_replace(
            ['content.md', '.md'],
            ['index.html', '.html'],
            $this->fileDestinationPathFor($path)
        );
    }

    private function fileDestinationPathFor(string $path): string
    {

        $relativePath = $this->relativePath($path);
        return $this->destination . $relativePath;
    }

    private function finder(): Finder
    {
        $finder = new Finder();
        return $finder->ignoreVCS(false)
            ->ignoreUnreadableDirs()
            ->ignoreDotFiles(false)
            ->ignoreVCSIgnored(true)
            ->files()
            ->filter(fn($f) => $this->isPublished($f))
            ->in($this->contentRoot);
    }

    private function isPublished(SplFileInfo $finderFile): bool
    {
        return ! $this->isDraft($finderFile);
    }

    private function isDraft(SplFileInfo $finderFile): bool
    {
        $filePath = (string) $finderFile;
        $relativePath = $this->relativePath($filePath);
        return str_contains($relativePath, '_');
    }

    private function relativePath(string $path): string
    {
        return str_replace($this->contentRoot, '', $path);
    }

    /**
     * @todo: We use League FlySystem because it does recursive folder creation.
     */
    private function leagueFileSystem(): LeagueFilesystem
    {
        if (! isset($this->leagueFileSystem)) {
            $adapter    = new LocalFilesystemAdapter('/');
            $fileSystem = new LeagueFilesystem($adapter);

            $this->leagueFileSystem = $fileSystem;
        }
        return $this->leagueFileSystem;
    }

    /**************************/
    /*    Console messages    */
    /**************************/
    private function output(): OutputInterface
    {
        return $this->output;
    }

    private function compilingDidStartMessage(
        string $contentPath,
        string $destinationPath
    ): void {
        if ($this->isNotTesting) {
            $this->output()->writeln(<<<bash

                Starting to compile from:
                    {$contentPath} to
                    {$destinationPath}
                bash
            );
        }
    }

    private function sourceFileCopiedMessage(
        string $contentPath,
        string $destinationPath
    ): void {
        if ($this->isNotTesting) {
            $this->output()->writeln(<<<bash

                Copied:
                    {$contentPath} to
                    {$destinationPath}
                bash
            );
        }
    }

    private function sourceFileConvertedMessage(
        string $contentPath,
        string $destinationPath
    ): void {
        if ($this->isNotTesting) {
            $this->output()->writeln(<<<bash

                Converted:
                    {$contentPath} to
                    {$destinationPath}
                bash
            );
        }
    }
}
