<?php

declare(strict_types=1);

namespace JoshBruce\Site\StaticGenerator;

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
    // private MarkdownConverter $markdownConverter;

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
        // $this->markdownConverter = MarkdownConverter::create()
        //     ->minified() // can't be minified due to code blocks
        //     ->smartPunctuation()
        //     ->withConfig(['html_input' => 'allow'])
        //     ->abbreviations()
        //     ->externalLinks([
        //         'open_in_new_window' => true
        //     ])->headingPermalinks(
        //         [
        //             'min_heading_level' => 2,
        //             'symbol' => '＃'
        //         ],
        //     );
    }

    public function compile(): bool
    {
        if ($this->isNotTesting) {
            $this->output()->writeln(<<<bash

                Starting to compile from:
                    {$this->contentRoot()} to
                    {$this->destination()}
                bash
            );
            $start = hrtime(true);
        }

        $finder = new Finder();
        $finder = $finder->in($this->contentRoot());
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

    private function copyFileFor(string $contentRootPath): void
    {
        $destinationPath = $this->fileDestinationPathFor($contentRootPath);
        $this->leagueFileSystem()->copy($contentRootPath, $destinationPath);
    }

    private function fileDestinationPathFor(string $contentRootPath): string
    {
        $destinationRelativePath = str_replace(
            'content/',
            '',
            $this->relativePathFor($contentRootPath)
        );
        return $this->destination() . $destinationRelativePath;
    }

    private function compileContentFileFor(string $contentRootPath): void
    {
        $destinationPath = $this->contentDestinationPathFor($contentRootPath);

        $parts = explode('/content/', $contentRootPath, 2);
        $root = array_shift($parts);
        array_unshift($parts, '');
        $file = array_pop($parts);
        $path = implode('/', $parts);
        if (empty($path)) {
            $path = '/';
        }

        $file = FileSystem::init($root, $path, $file);
        if ($file->notFound()) {
            $this->output()->writeln(<<<bash

                Source file not found for:
                    {$contentRootPath} to
                    {$destinationPath}
                bash
            );
            return;
        }

        $body = Markdown::init($file)->convert();

        $content = DefaultTemplate::create(
            $body,
            $file->mimeType(),
            $file->folderStack(),
            $root
        );

        $this->leagueFileSystem()->write($destinationPath, $content->body());

        $this->output()->writeln(<<<bash

            Converted:
                {$contentRootPath} to
                {$destinationPath}
            bash
        );
    }

    private function contentDestinationPathFor(string $path): string
    {
        return str_replace(
            ['content.md', '.md'],
            ['index.html', '.html'],
            $this->fileDestinationPathFor($path)
        );
    }

    private function relativePathFor(string $path): string
    {
        return str_replace($this->contentRoot(), '', $path);
    }

    private function output(): OutputInterface
    {
        return $this->output;
    }

    private function contentRoot(): string
    {
        return $this->contentRoot;
    }

    private function destination(): string
    {
        return $this->destination;
    }

    private function markdownConverter(): MarkdownConverter
    {
        return Markdown::markdownConverter();
    }

    private function leagueFileSystem(): LeagueFilesystem
    {
        if (! isset($this->leagueFileSystem)) {
            $adapter    = new LocalFilesystemAdapter('/');
            $fileSystem = new LeagueFilesystem($adapter);

            $this->leagueFileSystem = $fileSystem;
        }
        return $this->leagueFileSystem;
    }
}
