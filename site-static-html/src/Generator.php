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

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem as LeagueFilesystem;

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





    private string $projectRoot;

    private FileSystem $fileSystem;

    private LeagueFilesystem $leagueFileSystem;

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
            // return $app->find('compile:dynamic')->run($input, $output);
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
                mkdir($rPath, 0777, true);
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

        foreach ($localFiles as $fileInfo) {
            if ($finder->isDraft($fileInfo)) {
                continue;
            }

            $file = File::from($fileInfo, $root);
            $path = $file->path(false);
            if (str_ends_with($path, '/content.md')) {
                $path = str_replace('/content.md', '', $path);
                $body = RequestHandler::in(
                    $environment
                )->handle(
                    new ServerRequest(
                        method: 'GET',
                        uri: $path
                    )
                )->getBody();

                $fDestination = $this->destination() . $path . '/index.html';
                $this->leagueFileSystem()->write($fDestination, (string) $body);

                continue;

            } elseif (str_contains($path, '/error-')) {
                $method = 'GET';
                $path   = $path;
                $fDestination = $this->destination() . $path;
                if (str_ends_with($path, '/error-404.md')) {
                    $path = '/path/does/not/ex/ist';
                    $fDestination = str_replace(
                        '/error-404.md',
                        '/error-404.html',
                        $fDestination
                    );

                } elseif (str_ends_with($path, '/error-405.md')) {
                    $method = 'DELETE';
                    $path = '/error-405.html';
                    $fDestination = str_replace(
                        '/error-405.md',
                        '/error-405.html',
                        $fDestination
                    );

                }

                $body = RequestHandler::in(
                    $environment
                )->handle(
                    new ServerRequest(
                        method: $method,
                        uri: $path
                    )
                )->getBody();

                $this->leagueFileSystem()->write($fDestination, (string) $body);

                continue;
            }

            $fDestination = $this->destination() . $path;
            $this->leagueFileSystem()->copy($file->path(), $fDestination);
        }

        die(var_dump('done with loop'));
        return true;
//
//         $destination = $input->getArgument('destination');
//         if (empty($destination)) {
//             $destination = $this->projectRoot . '/site-static-html/public';
//         }
//
//         $finder = $this->finder();
//
//         $count = count($finder);
//
//         $progressBar = new ProgressBar($output, $count);
//         $progressBar->start();
//
//         foreach ($finder as $found) {
//             $localPath = $found->getPathname();
//
//             $file = File::at($localPath, $this->fileSystem());
//
//             $fDestination = $destination . $file->path(false);
//
//             // copy non-html and xml files directly
//             if ($file->isNotXml()) {
//                 // $fDestination = $destination . $file->path(false);
                // $this->leagueFileSystem()->copy($file->path(), $fDestination);
//                 $progressBar->advance();
//                 continue;
//             }
//
//             $uri = str_replace(
//                 [$this->fileSystem()->publicRoot(), 'content.md'],
//                 ['', ''],
//                 $localPath
//             );
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
            // $this->leagueFileSystem()->write($fDestination, $body);
//
//             $progressBar->advance();
//
//         }
//
//         $output->writeln('');
//
//         return true;
    }
//
//     private function finder(): Finder
//     {
//         $finder = new Finder();
//         return $finder->ignoreVCS(false)
//             ->ignoreUnreadableDirs()
//             ->ignoreDotFiles(false)
//             ->ignoreVCSIgnored(true)
//             ->notName('.gitignore')
//             ->files()
//             ->filter(fn($f) => $this->isPublished($f))
//             ->in($this->fileSystem()->publicRoot());
//     }
//
//     private function isPublished(SplFileInfo $finderFile): bool
//     {
//         return ! $this->isDraft($finderFile);
//     }
//
//     private function isDraft(SplFileInfo $finderFile): bool
//     {
//         $filePath = (string) $finderFile;
//         $file = File::at($filePath, $this->fileSystem());
//         $relativePath = $file->path(false);
//         return str_contains($relativePath, '_');
//     }
//
//     private function fileSystem(): FileSystem
//     {
//         if (! isset($this->fileSystem)) {
//             $this->fileSystem = FileSystem::init();
//         }
//         return $this->fileSystem;
//     }
//
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
