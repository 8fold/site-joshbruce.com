<?php

declare(strict_types=1);

namespace JoshBruce\Site\Content;

use Eightfold\Markdown\Markdown as MarkdownConverter;

use JoshBruce\Site\File;
use JoshBruce\Site\FileSystemInterface;

use JoshBruce\Site\Documents\Sitemap;

use JoshBruce\Site\PageComponents\Data;
use JoshBruce\Site\PageComponents\DateBlock;
use JoshBruce\Site\PageComponents\LogList;
use JoshBruce\Site\PageComponents\OriginalContentNotice;

class Markdown
{
    private static MarkdownConverter $markdownConverter;
    private string $fileContent = '';

    private string $body = '';

    public static function for(File $file, FileSystemInterface $in): Markdown
    {
        return new Markdown($file, $in);
    }

    public static function markdownConverter(): MarkdownConverter
    {
        if (! isset(self::$markdodwnConverter)) {
            self::$markdownConverter = MarkdownConverter::create()
                ->minified() // can't be minified due to code blocks
                ->smartPunctuation()
                ->withConfig(['html_input' => 'allow'])
                ->descriptionLists()
                ->attributes()
                ->abbreviations()
                ->externalLinks([
                    'open_in_new_window' => true,
                    'internal_hosts' => 'joshbruce.com'
                ])->accessibleHeadingPermalinks(
                    [
                        'min_heading_level' => 2,
                        'symbol' => '＃'
                    ],
                );
        }
        return self::$markdownConverter;
    }

    private function __construct(
        private File $file,
        private FileSystemInterface $fileSystem
    ) {
    }

    public function html(): string
    {
        $body = $this->body();

        $inserts = [];
        if (preg_match_all('/{!!(.*)!!}/', $body, $inserts)) {
            $templateMap = [
                'data'      => Data::class,
                'dateblock' => DateBlock::class,
                'full-nav'  => Sitemap::class,
                'loglist'   => LogList::class,
                'original'  => OriginalContentNotice::class
            ];

            $replacements = $inserts[0];
            $templates    = $inserts[1];
            for ($i = 0; $i < count($replacements); $i++) {
                $templateKey = $templates[$i];
                if (! array_key_exists($templateKey, $templateMap)) {
                    continue;
                }

                $b = '';
                $template = $templateMap[$templateKey];
                if ($templateKey === 'loglist') {
                    $b = $template::create($this->file(), $this->fileSystem());

                } elseif ($templateKey === 'full-nav') {
                    $b = $template::list($this->fileSystem());

                } else {
                    $b = $template::create(
                        $this->file(),
                        $this->fileSystem()
                    );

                }


                $body = str_replace($replacements[$i], $b, $body);
            }
        }
        return self::markdownConverter()->convert($body);
    }

    public function body(): string
    {
        if (strlen($this->body) === 0) {
            $this->body = self::markdownConverter()
                ->getBody($this->fileContent());
        }
        return $this->body;
    }

    public function file(): File
    {
        return $this->file;
    }

    private function fileContent(): string
    {
        if (strlen($this->fileContent) === 0 and $this->file()->found()) {
            $this->fileContent = $this->file()->contents();
        }
        return $this->fileContent;
    }

    private function fileSystem(): FileSystemInterface
    {
        return $this->fileSystem;
    }
}
