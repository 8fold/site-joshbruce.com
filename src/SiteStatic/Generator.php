<?php

declare(strict_types=1);

namespace JoshBruce\Site\SiteStatic;

use SplFileInfo;

use Dotenv\Dotenv;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

use Symfony\Component\Finder\Finder;

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem as LeagueFilesystem;

use JoshBruce\Site\ServerGlobals;
use JoshBruce\Site\FileSystem;
use JoshBruce\Site\File;
use JoshBruce\Site\HttpResponse;
use JoshBruce\Site\HttpRequest;

class Generator extends Command
{
    protected static $defaultName = 'compile';

    protected static $defaultDescription =
        'Compile content and assets for dynamic and static sites.';

    private string $projectRoot;

    private FileSystem $fileSystem;

    private LeagueFilesystem $leagueFileSystem;

    protected function configure(): void
    {
        $this->setHelp('This command uses the content directory and dynamic
            site capabilities to generate a complete static site.');

        $this->addArgument(
            'destination',
            InputArgument::OPTIONAL,
            '/fully/qualified/path/for/static/site/destination - default is
                the project root in a folder called site-static-html'
        );

        $this->projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -2));

        if (File::at($this->projectRoot . '/.env', $this->fileSystem())) {
            Dotenv::createImmutable($this->projectRoot)->load();
        }
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $start = hrtime(true);

        if ($this->compiledStaticSite($input, $output)) {
            $end   = hrtime(true);
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
                return Command::SUCCESS;
            }
            return $app->find('compile:dynamic')->run($input, $output);
        }

        $output->writeln(<<<bash

            Failed!

            Did not compile the static site.

            bash
        );
        return Command::FAILURE;
    }

    private function compiledStaticSite(
        InputInterface $input,
        OutputInterface $output
    ): bool {
        $output->writeln([
            '',
            'Starting static site compilation',
            '******************************************',
            ''
        ]);

        $destination = $input->getArgument('destination');
        if (empty($destination)) {
            $destination = $this->projectRoot . '/site-static-html/public';
        }

        $finder = $this->finder();

        $count = count($finder);

        $progressBar = new ProgressBar($output, $count);
        $progressBar->start();

        foreach ($finder as $found) {
            $localPath = $found->getPathname();

            $file = File::at($localPath, $this->fileSystem());

            $fDestination = $destination . $file->path(false);

            // copy non-html and xml files directly
            if ($file->isNotXml()) {
                // $fDestination = $destination . $file->path(false);
                $this->leagueFileSystem()->copy($file->path(), $fDestination);
                $progressBar->advance();
                continue;
            }

            $uri = str_replace(
                [$this->fileSystem()->publicRoot(), 'content.md'],
                ['', ''],
                $localPath
            );

            if ($uri === '/') {
                $uri = '';
            }

            $body = HttpResponse::from(
                HttpRequest::with(
                    ServerGlobals::init()->withRequestUri($uri),
                    $this->fileSystem()
                )
            )->body();

            $fDestination = str_replace(
                ['content.md', '.md'],
                ['index.html', '.html'],
                $fDestination
            );

            $this->leagueFileSystem()->write($fDestination, $body);

            $progressBar->advance();

        }

        $output->writeln('');

        return true;
    }

    private function finder(): Finder
    {
        $finder = new Finder();
        return $finder->ignoreVCS(false)
            ->ignoreUnreadableDirs()
            ->ignoreDotFiles(false)
            ->ignoreVCSIgnored(true)
            ->notName('.gitignore')
            ->files()
            ->filter(fn($f) => $this->isPublished($f))
            ->in($this->fileSystem()->publicRoot());
    }

    private function isPublished(SplFileInfo $finderFile): bool
    {
        return ! $this->isDraft($finderFile);
    }

    private function isDraft(SplFileInfo $finderFile): bool
    {
        $filePath = (string) $finderFile;
        $file = File::at($filePath, $this->fileSystem());
        $relativePath = $file->path(false);
        return str_contains($relativePath, '_');
    }

    private function fileSystem(): FileSystem
    {
        if (! isset($this->fileSystem)) {
            $this->fileSystem = FileSystem::init();
        }
        return $this->fileSystem;
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
}
