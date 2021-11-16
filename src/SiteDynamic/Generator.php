<?php

declare(strict_types=1);

namespace JoshBruce\Site\SiteDynamic;

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
    protected static $defaultName = 'compile:dynamic';

    protected static $defaultDescription =
        'Compile content and assets for dynamic sites.';

    private string $projectRoot;

    private FileSystem $fileSystem;

    private LeagueFilesystem $leagueFileSystem;

    protected function configure(): void
    {
        $this->setHelp(
            // phpcs:ignore
            'This command uses the content directory and dynamic site capabilities to compile or copy assets for dynamic sites.'
        );

        $this->addArgument(
            'destination',
            InputArgument::OPTIONAL,
            // phpcs:ignore
            '/fully/qualified/path/for/static/site/destination - default is the project root in a folder called site-dynamic-php'
        );

        $this->projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -2));

        Dotenv::createImmutable($this->projectRoot)->load();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $start = hrtime(true);

        if ($this->compiledDynamicSite($input, $output)) {
            $end   = hrtime(true);
            $elapsed = $end - $start;
            $ms      = round($elapsed / 1e+6);
            $seconds = round($ms / 1000, 2);

            $output->writeln([
                '',
                '******************************************',
                "Completed dynamic site compilation in {$seconds}s",
                ''
            ]);

            return Command::SUCCESS;
        }

        $output->writeln(<<<bash

            Failed!

            Did not compile dynamic site assets.

            bash
        );
        return Command::FAILURE;
    }

    private function compiledDynamicSite(
        InputInterface $input,
        OutputInterface $output
    ): bool {
        $output->writeln([
            '',
            'Starting dynamic site compilation',
            '******************************************',
            ''
        ]);

        $destination = $input->getArgument('destination');
        if (empty($destination)) {
            $destination = $this->projectRoot . '/site-dynamic-php/public';
        }

        $finder = $this->finder();

        $count = count($finder);

        $progressBar = new ProgressBar($output, $count);
        $progressBar->start();

        foreach ($finder as $found) {
            $localPath = $found->getPathname();

            $file = File::at($localPath, $this->fileSystem());

            $fDestination = $destination . $file->path(false);

            if ($file->fileName() !== '.htaccess') {
                $this->leagueFileSystem()->copy($file->path(), $fDestination);
                $progressBar->advance();
                continue;
            }

            $body = str_replace(
                [
                    "ErrorDocument 404 /error-404.html\n",
                    "ErrorDocument 405 /error-405.html\n"
                ],
                ['', ''],
                file_get_contents($file->path())
            );

            $body .= <<<plain

                <IfModule mod_rewrite.c>
                    RewriteEngine On

                    # Handle Authorization Header
                    RewriteCond %{HTTP:Authorization} .
                    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

                    # Redirect Trailing Slashes If Not A Folder...
                    RewriteCond %{REQUEST_FILENAME} !-d
                    RewriteCond %{REQUEST_URI} (.+)/$
                    RewriteRule ^ %1 [L,R=301]

                    # Send Requests To Front Controller...
                    RewriteCond %{REQUEST_FILENAME} !-d
                    RewriteCond %{REQUEST_FILENAME} !-f
                    RewriteRule ^ index.php [L]
                </IfModule>

                <IfModule mod_expires.c>
                    ExpiresActive On
                    ExpiresDefault "access plus 5 seconds"
                </IfModule>

                plain;

//
//             if ($uri === '/') {
//                 $uri = '';
//             }
//
//             $body = HttpResponse::from(
//                 HttpRequest::with(
//                     ServerGlobals::init()->withRequestUri($uri),
//                     $this->fileSystem()
//                 )
//             )->body();
//
//             $fDestination = str_replace(
//                 ['content.md', '.md'],
//                 ['index.html', '.html'],
//                 $fDestination
//             );
//
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
            ->notName('*.md')
            ->notName('*.xml')
            ->name('.htaccess')
            ->name('*.txt')
            ->name('*.html')
            ->files()
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
