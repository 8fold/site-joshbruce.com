<?php

declare(strict_types=1);

namespace JoshBruce\StaticSite;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem as LeagueFilesystem;

use Eightfold\Markdown\Markdown as MarkdownConverter;

use JoshBruce\Site\FileSystem;
use JoshBruce\Site\Content\Markdown;

use JoshBruce\Site\Pages\DefaultTemplate;

class Generator
{
    private bool $isNotTesting = false;

    private LeagueFilesystem $leagueFileSystem;

    public static function init(
        OutputInterface $output,
        string $contentRoot,
        string $destination
    ): Generator {
        return new Generator($output, $contentRoot, $destination);
    }

    public function __construct(
        private OutputInterface $output,
        private string $contentRoot,
        private string $destination
    ) {
        if (isset($_SERVER['APP_ENV'])) {
            $this->isNotTesting = $_SERVER['APP_ENV'] !== 'testing';
        }
    }

    public function compile(): bool
    {
        $this->compilingDidStartMessage($this->contentRoot, $this->destination);

        $finder = new Finder();
        $finder = $finder->ignoreVCS(false)
            ->ignoreUnreadableDirs()
            ->ignoreDotFiles(false)
            ->in($this->contentRoot);
        foreach ($finder as $found) {
            $path = (string) $found;
            if (strpos($path, '_') > 0 or $found->isDir()) {
                continue;
            }

            if (str_contains($path, '.md')) {
                $this->compileContentFileFor($path);

            } else {
                $this->copyFileFor($path);

            }
        }

        if ($this->isNotTesting) {
            $end = hrtime(true);
        }
        return true;
    }


    private function compileContentFileFor(string $contentPath): void
    {
        $contentRoot = $this->contentRoot;
        $path        = str_replace($contentRoot, '', $contentPath);

        $parts       = explode('/', $path);

        $fileName    = array_pop($parts);

        $folderPath  = implode('/', $parts);
        if (strlen($folderPath) === 0) {
            $folderPath = '/';
        }

        $destinationPath = $this->contentDestinationPathFor($contentPath);

        $file = FileSystem::init($contentRoot, $folderPath, $fileName);

        $body = Markdown::init($file)->convert();

        $content = DefaultTemplate::create(
            $body,
            $file->mimeType(),
            $file->folderStack(),
            $contentRoot
        )->body();

        $this->leagueFileSystem()->write($destinationPath, $content);

        $this->sourceFileConvertedMessage($contentPath, $destinationPath);
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
        $contentRoot  = $this->contentRoot;
        $relativePath = str_replace($contentRoot, '', $path);

        return $this->destination . $relativePath;
    }

    private function copyFileFor(string $path): void
    {
        $destinationPath = $this->fileDestinationPathFor($path);
        $this->leagueFileSystem()->copy($path, $destinationPath);
        $this->sourceFileCopiedMessage($path, $destinationPath);
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

    private function sourceFileConvertedMessage(
        string $contentPath,
        string $destinationPath
    ): void {
        $this->output()->writeln(<<<bash

            Converted:
                {$contentPath} to
                {$destinationPath}
            bash
        );
    }

    private function sourceFileCopiedMessage(
        string $contentPath,
        string $destinationPath
    ): void {
        $this->output()->writeln(<<<bash

            Copied:
                {$contentPath} to
                {$destinationPath}
            bash
        );
    }
}
