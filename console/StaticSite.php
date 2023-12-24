<?php

namespace JoshBruce\Console;

use SplFileinfo;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\ConsoleSectionOutput;

use Symfony\Component\Finder\Finder as SymfonyFinder;

use Eightfold\Amos\Site;
use Eightfold\Amos\Http\Root as HttpRoot;
use Eightfold\Amos\FileSystem\Directories\Root as ContentRoot;

use Eightfold\Markdown\Markdown;

use JoshBruce\Site\Templates\Page;
use JoshBruce\Site\Templates\PageNotFound;
use JoshBruce\Site\Documents\Sitemap as SitemapResponse;

class StaticSite extends Command
{
    private Site $site;

    private string $domain;

    private string $publicRoot;

    private string $publicContentRoot;

    private string $projectRoot;

    private string $staticRoot;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->domain = $input->getArgument('domain');

        $output->writeln([
            '',
            'Amos Generating Static Site',
            '===========================',
            ''
        ]);

        $amosSection = $output->section();
        $amosSection->writeln('Generator: Starting');

        if ($this->publicRoot() === false) {
            $amosSection->overwrite('Generator: Failed to find public root');
            return Command::FAILURE;
        }

        $sitemapSection = $output->section();
        $sitemapSection->writeln('Sitemap: Generating sitemap');

        $sitemap = new SitemapResponse();
        $invoked = $sitemap($this->site());
        $content = $invoked->getBody()->getContents();

        $savePath = $this->staticRoot() . '/sitemap.xml';

        if (file_put_contents($savePath, $content) === false) {
            $sitemapSection->overwrite('Sitemap: Failed to save sitemap');
            return Command::FAILURE;

        } else {
            $sitemapSection->overwrite('Sitemap: Success!');

        }

        $rootFilesSection = $output->section();
        $rootFilesSection->writeln('Root files and folders: Copying');

        $copied = $this->didCopyFolderAndFiles(
            $this->publicRoot(),
            $this->staticRoot(),
            'Root files and folders',
            $rootFilesSection
        );
        if ($copied === false) {
            $amosSection->overwrite('Generator: Failed to copy root files and folders');
            return Command::FAILURE;

        } else {
            $rootFilesSection->overwrite('Root files and folders: Success!');

        }

        $iterator = (new SymfonyFinder())->files()->name('meta.json')
            ->in(
                $this->site()->publicRoot()->toString()
            )->sortByName();

        $dirCreatorSection = $output->section();
        $total             = 0;
        $iteratorTotal     = $iterator->count();
        $dirCreatorSection->writeln('Content directories: ' . $total . ' of ' . $iteratorTotal);
        foreach ($iterator as $meta) {
            $metaPath    = $meta->getRealPath();
            $requestPath = str_replace([$this->publicContentRoot(), 'meta.json'], ['', ''], $metaPath);

            $dest = $this->staticRoot() . $requestPath;
            if (is_dir($dest) === false and mkdir($dest, recursive: true) === false) {
                $dirCreatorSection->overwrite('Content directories: Failed to create directory for ' . $dest);
                return Command::FAILURE;
            }

            $total = $total + 1;
            $dirCreatorSection->overwrite('Content directories: ' . $total . ' of ' . $iteratorTotal);
        }
        $dirCreatorSection->overwrite('Content directories: Success!');

        $pageProcessingSection = $output->section();
        $total                 = 0;
        $iteratorTotal         = $iterator->count() + 1;
        $pageProcessingSection->writeln('Content files: ' . $total . ' of ' . $iteratorTotal);
        foreach ($iterator as $meta) {
            $metaPath    = $meta->getRealPath();
            $requestPath = str_replace([$this->publicContentRoot(), 'meta.json'], ['', ''], $metaPath);
            $dest        = $this->staticRoot() . $requestPath . 'index.html';
            $current     = '';
            if (is_file($dest)) {
                $current = file_get_contents($dest);
            }

        $converter = Markdown::create()
            ->withConfig([
                'html_input' => 'allow'
            ])->defaultAttributes([
                Image::class => [
                    'loading'  => 'lazy',
                    'decoding' => 'async'
                ]
            ])->externalLinks([
                'open_in_new_window' => true,
                'internal_hosts'     => $this->site()->domain()->toString()
            ])->accessibleHeadingPermalinks([
                'min_heading_level' => 2,
                'max_heading_level' => 3,
                'symbol'            => '＃'
            ])->minified()
            ->smartPunctuation()
            ->descriptionLists()
            ->tables()
            ->attributes() // for class on notices
            ->abbreviations()
            ->partials([ // TODO: Make it possible to override these settings
                'partials' => [
                    'dateblock'        => DateBlock::class,
                    'next-previous'    => NextPrevious::class,
                    'article-list'     => ArticleList::class,
                    'paycheck-loglist' => PaycheckLogList::class,
                    'original'         => OriginalContentNotice::class,
                    'data'             => Data::class,
                    'fi-experiments'   => FiExperiments::class,
                    'full-nav'         => FullNav::class,
                    'health-loglist'   => HealthLogList::class
                ],
                'extras' => [
                    'meta'         => $meta,
                    'site'         => $this->site(),
                    'request_path' => $requestPath
                ]
            ]);

            $body = (string) Page::create($this->site())
                ->withConverter($converter)
                ->withRequestPath($requestPath);

            if ($current !== $body and file_put_contents($dest, $body) === false) {
                $pageProcessingSection->overwrite('Content files: Failed to save file for '  . $dest);
                return Command::FAILURE;
            }

            $total = $total + 1;
            $pageProcessingSection->overwrite('Content files: ' . $total . ' of ' . $iteratorTotal);
        }
        $requestPath = '/_some/_thing_/_non-exist-ent';
        $converter = Markdown::create()
            ->withConfig([
                'html_input' => 'allow'
            ])->defaultAttributes([
                Image::class => [
                    'loading'  => 'lazy',
                    'decoding' => 'async'
                ]
            ])->externalLinks([
                'open_in_new_window' => true,
                'internal_hosts'     => $this->site()->domain()->toString()
            ])->accessibleHeadingPermalinks([
                'min_heading_level' => 2,
                'max_heading_level' => 3,
                'symbol'            => '＃'
            ])->minified()
            ->smartPunctuation()
            ->descriptionLists()
            ->tables()
            ->attributes() // for class on notices
            ->abbreviations()
            ->partials([
                'partials' => [
                    'dateblock'        => DateBlock::class,
                    'next-previous'    => NextPrevious::class,
                    'article-list'     => ArticleList::class,
                    'paycheck-loglist' => PaycheckLogList::class,
                    'original'         => OriginalContentNotice::class,
                    'data'             => Data::class,
                    'fi-experiments'   => FiExperiments::class,
                    'full-nav'         => FullNav::class,
                    'health-loglist'   => HealthLogList::class
                ],
                'extras' => [
                    'meta'         => $meta,
                    'site'         => $this->site(),
                    'request_path' => $requestPath
                ]
            ]);
        $body = (string) PageNotFound::create($this->site())
            ->withConverter($converter)
            ->withRequestPath($requestPath);
        if (file_put_contents($this->staticRoot() . '/error-404.html', $body) === false) {
            $pageProcessingSection->overwrite('Content files: Faile to create 404 error page');
            return Command::FAILURE;
        }
        $pageProcessingSection->overwrite('Content files: Success!');

        $amosSection->overwrite('Generator: Success!');

        $output->writeln('');

        return Command::SUCCESS;
    }

    public function configure(): void
    {
        $this->setName('sitemap')
            ->addArgument('domain', InputArgument::REQUIRED, 'The HTTP root to use.');
    }

    private function site(): Site
    {
        if (isset($this->site) === false) {
            $this->site = Site::init(
                ContentRoot::fromString(__DIR__ . '/../content-root'),
                HttpRoot::fromString($this->domain())
            );
        }
        return $this->site;
    }

    private function domain(): string
    {
        return $this->domain;
    }

    private function publicContentRoot(): string|false
    {
        if ($this->projectRoot() === false) {
            return false;
        }

        if (isset($this->publicContentRoot) === false) {
            $dir = new SplFileinfo($this->projectRoot() . '/content-root/public');
            if (is_dir($dir) === false) {
                return false;
            }
            $this->publicContentRoot = $dir->getRealPath();
        }
        return $this->publicContentRoot;
    }

    private function publicRoot(): string|false
    {
        if ($this->projectRoot() === false) {
            return false;
        }

        if (isset($this->publicRoot) === false) {
            $dir = new SplFileinfo($this->projectRoot() . '/site-root/public');
            if (is_dir($dir) === false) {
                return false;
            }
            $this->publicRoot = $dir->getRealPath();
        }
        return $this->publicRoot;
    }

    private function projectRoot(): string|false
    {
        if (isset($this->projectRoot) === false) {
            $dir = new SplFileinfo(__DIR__ . '/../');
            $this->projectRoot = $dir->getRealPath();
        }
        return $this->projectRoot;
    }

    private function staticRoot(): string|false
    {
        if ($this->projectRoot() === false) {
            return false;
        }

        if (isset($this->staticRoot) === false) {
            $dir = new SplFileinfo($this->projectRoot() . '/../public-static');
            if (is_dir($dir) === false and mkdir($dir, recursive: true) === false) {
                return false;
            }
            $this->staticRoot = $dir->getRealPath();
        }
        return $this->staticRoot;
    }

    /**
     * Based on: https://onlinewebtutorblog.com/copy-entire-contents-of-a-directory-to-another-directory-in-php/
     *
     * @param string $src
     * @param string $dest
     * @param string $sectionPrefix
     * @param ConsoleSectionOutput $section
     *
     * @return bool
     */
    private function didCopyFolderAndFiles(
        string $src,
        string $dest,
        string $sectionPrefix,
        ConsoleSectionOutput $section
    ): bool {
        if (is_dir($src) === false) {
            return false;
        }

        if (
            is_dir($dest) === false and
            mkdir($dest, recursive: true) === false
        ) {
            return false;
        }

        $dir = opendir($src);
        while ($fileOrFolder = readdir($dir)) {
            if (
                $fileOrFolder === 'index.php' or
                (str_starts_with($fileOrFolder, '.') and $fileOrFolder !== '.htaccess')
            ) {
                continue;
            }

            $copied = true;
            if (is_dir($src . '/' . $fileOrFolder)) {
                $copied = $this->didCopyFolderAndFiles(
                    $src . '/' . $fileOrFolder,
                    $dest . '/' . $fileOrFolder,
                    $sectionPrefix,
                    $section
                );

                if ($copied === false) {
                    $section->overwrite($sectionPrefix . ': Failed to copy folder ' . $fileOrFolder);
                    return false;
                }

            } else {
                $copied = copy($src . '/' . $fileOrFolder, $dest . '/' . $fileOrFolder);

                if ($copied === false) {
                    $section->overwrite($sectionPrefix . ': Failed to copy file ' . $fileOrFolder);
                    return false;
                }
            }
        }

        closedir($dir);

        return true;
    }
}
