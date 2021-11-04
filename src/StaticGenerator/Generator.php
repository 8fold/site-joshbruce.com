<?php

declare(strict_types=1);

namespace JoshBruce\Site\StaticGenerator;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem;

use Eightfold\Markdown\Markdown as MarkdownConverter;

class Generator
{
    private MarkdownConverter $markdownConverter;

    private FileSystem $fileSystem;

    public static function run(
        OutputInterface $output,
        string $source,
        string $destionation
    ): bool {
        $compiler = new Generator($output, $source, $destionation);
        return $compiler->compile();
    }

    public function __construct(
        private OutputInterface $output,
        private string $source,
        private string $destionation
    ) {
        $this->markdownConverter = MarkdownConverter::create()
            ->minified() // can't be minified due to code blocks
            ->smartPunctuation()
            ->withConfig(['html_input' => 'allow'])
            ->abbreviations()
            ->externalLinks([
                'open_in_new_window' => true
            ])->headingPermalinks(
                [
                    'min_heading_level' => 2,
                    'symbol' => '＃'
                ],
            );
    }

    private function compile(): bool
    {
        $this->output()->writeln(<<<bash

            Starting to compile from:
                {$this->source()} to
                {$this->destination()}
            bash
        );

        $start = hrtime(true);

        $finder = new Finder();
        $finder = $finder->in($this->source());
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

        $end = hrtime(true);
        return true;
    }

    private function copyFileFor(string $sourcePath): void
    {
        $destinationPath = $this->fileDestinationPathFor($sourcePath);
        $this->fileSystem()->copy($sourcePath, $destinationPath);
    }

    private function fileDestinationPathFor(string $sourcePath): string
    {
        $destinationRelativePath = str_replace(
            'content/',
            '',
            $this->relativePathFor($sourcePath)
        );
        return $this->destination() . $destinationRelativePath;
    }

    private function compileContentFileFor(string $sourcePath): void
    {
        $contents = $this->markdownConverter()->convert(
            file_get_contents($sourcePath)
        );

        $destinationPath = $this->contentDestinationPathFor($sourcePath);

        $this->filesystem()->write($destinationPath, $contents);

        $this->output()->writeln(<<<bash

            Converted:
                {$sourcePath} to
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
        return str_replace($this->source(), '', $path);
    }

    private function output(): OutputInterface
    {
        return $this->output;
    }

    private function source(): string
    {
        return $this->source . '/content';
    }

    private function destination(): string
    {
        return $this->destionation;
    }

    private function markdownConverter(): MarkdownConverter
    {
        return $this->markdownConverter;
    }

    private function fileSystem(): FileSystem
    {
        if (! isset($this->fileSystem)) {
            $adapter    = new LocalFilesystemAdapter('/');
            $fileSystem = new Filesystem($adapter);

            $this->fileSystem = $fileSystem;
        }
        return $this->fileSystem;
    }
}
