<?php

declare(strict_types=1);

namespace JoshBruce\SiteStatic;

use Symfony\Component\Console\Command\Command;

use SplFileInfo;

// use Dotenv\Dotenv;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

// use Symfony\Component\Finder\Finder;

use Nyholm\Psr7\ServerRequest;

// use League\Flysystem\Local\LocalFilesystemAdapter;
// use League\Flysystem\Filesystem as LeagueFilesystem;

use JoshBruce\SiteDynamic\Environment;
use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\FileSystem\File;
use JoshBruce\SiteDynamic\Http\RequestHandler;
// use JoshBruce\Site\ServerGlobals;
// use JoshBruce\Site\FileSystem;
// use JoshBruce\Site\File;
// use JoshBruce\Site\HttpResponse;
// use JoshBruce\Site\HttpRequest;

class Generator extends Command
{
    protected static $defaultName = 'compile';

    protected static $defaultDescription =
        'Compile content and assets for dynamic and static sites.';

    private InputInterface $input;

    private OutputInterface $output;

    private string $pathToEnv = '';

    private string $destination = '';

    protected function configure(): void
    {
        $this->setHelp('This command uses the content directory and dynamic site capabilities to generate a complete static site.');

        $this->addArgument(
            'destination',
            InputArgument::OPTIONAL,
            '/path/to/destination - default is /../../site-static-html/public'
        );

        $this->addArgument(
            'path-to-env',
            InputArgument::OPTIONAL,
            '/path/to/.env - default is /../../'
        );
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $start = hrtime(true);

        $this->input  = $input;
        $this->output = $output;

        if ($this->compiledStaticSite()) {
            $end     = hrtime(true);
            $elapsed = $end - $start;
            $ms      = round($elapsed / 1e+6);
            $seconds = round($ms / 1000, 2);

            $output->writeln([
                '',
                '******************************************',
                "Completed static site compilation in {$seconds}s",
                ''
            ]);

            $app = $this->getApplication();
            if ($app === null) {
                $output->writeln([
                    '',
                    '!! Dynamic site compilation did NOT run !!',
                    ''
                ]);
            }
            return Command::SUCCESS;
        }

        $output->writeln(<<<bash

            Failed!

            Did not compile the static site.

            bash
        );
        return Command::FAILURE;
    }

    private function destination(): string
    {
        if (strlen($this->destination) === 0) {
            $rPath = $this->input()->getArgument('destination');
            if ($rPath === null) {
                $rPath = __DIR__ . '/../../site-static-html/public';
            }

            $realPath = (new SplFileInfo($rPath))->getRealPath();
            if (! $realPath) {
                mkdir($rPath, recursive: true);
                $realPath = (new SplFileInfo($rPath))->getRealPath();
            }

            $this->destination = $realPath;
        }
        return $this->destination;
    }

    private function pathToEnv(): string
    {
        if (strlen($this->pathToEnv) === 0) {
            $rPath = $this->input()->getArgument('path-to-env');
            if ($rPath === null) {
                $rPath = __DIR__ . '/../../';
            }

            $realPath = (new SplFileInfo($rPath))->getRealPath();
            if (! $realPath) {
                $realPath = __DIR__;
            }

            $this->pathToEnv = $realPath;
        }
        return $this->pathToEnv;
    }

    private function input(): InputInterface
    {
        return $this->input;
    }

    private function output(): OutputInterface
    {
        return $this->output;
    }

    private function compiledStaticSite(): bool
    {
        $this->output()->writeln([
            '',
            'Starting static site compilation',
            '******************************************',
            ''
        ]);

        $environment = Environment::with(
            pathToEnv: $this->pathToEnv()
        );

        $root = $environment->publicRoot();

        $finder = Finder::init($root);

        $localFiles = $finder->allFiles();

        $count = count($localFiles);

        $progressBarSection = $this->output()->section();
        $stepSection = $this->output()->section();

        $progressBar = new ProgressBar($progressBarSection);
        $progressBar->start($count);

        $stepSection->writeLn(['', 'Starting...']);

        foreach ($localFiles as $fileInfo) {
            if ($finder->isDraft($fileInfo)) {
                $progressBar->advance();
                continue;
            }

            $file = File::from($fileInfo, $root);
            $path = $file->path(false);
            if (str_ends_with($path, '/content.md')) {
                $stepSection->overwrite([
                    '',
                    'Compiling: ' . $file->path(false, true)
                ]);
                $this->processContentPage($file, $environment, $progressBar);

            } elseif (str_ends_with($path, '/sitemap.xml')) {
                $stepSection->overwrite([
                    '',
                    'Compiling: ' . $file->path(false)
                ]);
                $this->processSiteMap($file, $environment, $progressBar);

            } elseif (str_contains($path, '/error-')) {
                $parts = explode('/', $path);
                $fileName = array_pop($parts);
                $dFileName = str_replace('.md', '.html', $fileName);
                $stepSection->overwrite([
                    '',
                    'Compiling: ' . $file->path(false) . '/' . $dFileName
                ]);
                $this->processErrorPage($file, $environment, $progressBar);

            } else {
                $stepSection->overwrite([
                    '',
                    'Copying: ' . $file->path(false)
                ]);
                $this->processFile($file, $progressBar);

            }
        }

        $stepSection->clear(2);

        return true;
    }

    private function processContentPage(
        File $file,
        Environment $environment,
        ProgressBar $progressBar
    ): void {
        $path = $file->path(false);
        $path = str_replace('/content.md', '', $path);

        $body = RequestHandler::in(
            $environment
        )->handle(
            new ServerRequest(
                method: 'GET',
                uri: $path
            )
        )->getBody();

        $dirPath = $this->destination() . $path;
        if (! file_exists($dirPath) and ! is_dir($dirPath)) {
            mkdir($dirPath, recursive: true);
        }
        $fDestination = $dirPath . '/index.html';
        file_put_contents($fDestination, (string) $body);

        $progressBar->advance();
    }

    private function processSiteMap(
        File $file,
        Environment $environment,
        ProgressBar $progressBar
    ): void {
        $path = $file->path(false);

        $body = RequestHandler::in(
            $environment
        )->handle(
            new ServerRequest(
                method: 'GET',
                uri: $path
            )
        )->getBody();

        $fDestination = $this->destination() . $path;
        file_put_contents($fDestination, (string) $body);

        $progressBar->advance();
    }

    private function processErrorPage(
        File $file,
        Environment $environment,
        ProgressBar $progressBar
    ): void {
        $path   = $file->path(false);

        $fDestination = $this->destination() . $path;
        if (str_ends_with($path, '/error-404.md')) {
            $path = '/path/does/not/ex/ist';
            $fDestination = str_replace(
                '/error-404.md',
                '/error-404.html',
                $fDestination
            );

        }

        $body = RequestHandler::in(
            $environment
        )->handle(
            new ServerRequest(
                method: 'GET',
                uri: $path
            )
        )->getBody();

        file_put_contents($fDestination, (string) $body);

        $progressBar->advance();
    }

    private function processFile(File $file, ProgressBar $progressBar): void
    {
        $path = $file->path(false);
        $fDestination = $this->destination() . $path;
        $parts = explode('/', $fDestination);
        array_pop($parts);
        $dirPath = implode('/', $parts);
        if (! is_file($dirPath) and ! is_dir($dirPath)) {
            mkdir($dirPath, recursive: true);
        }
        copy($file->path(), $fDestination);

        $progressBar->advance();
    }
}
