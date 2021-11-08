<?php

declare(strict_types=1);

namespace JoshBruce\Site\Content;

use Eightfold\Markdown\Markdown as MarkdownConverter;

use JoshBruce\Site\File;

use JoshBruce\Site\PageComponents\Data;
use JoshBruce\Site\PageComponents\DateBlock;
use JoshBruce\Site\PageComponents\LogList;
use JoshBruce\Site\PageComponents\OriginalContentNotice;

class Markdown
{
    private string $fileContent = '';

    /**
     * @var FrontMatter
     */
    private FrontMatter $frontMatter;

    private string $body = '';

    public static function for(File $file): Markdown
    {
        return new Markdown($file);
    }

    public static function markdownConverter(): MarkdownConverter
    {
        return MarkdownConverter::create()
            ->minified() // can't be minified due to code blocks
            ->smartPunctuation()
            ->withConfig(['html_input' => 'allow'])
            ->descriptionLists()
            ->attributes()
            ->abbreviations()
            ->externalLinks([
                'open_in_new_window' => true,
                'internal_hosts' => 'joshbruce.com'
            ])->headingPermalinks(
                [
                    'min_heading_level' => 2,
                    'symbol' => '＃'
                ],
            );
    }

    private function __construct(private File $file)
    {
    }

    public function html(): string
    {
        $body = $this->body();

        $inserts = [];
        if (preg_match_all('/{!!(.*)!!}/', $body, $inserts)) {
            $templateMap = [
                'data'      => Data::class,
                'dateblock' => DateBlock::class,
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
                    $b = $template::create($this->file);

                } else {
                    $b = $template::create($this->frontMatter());

                }


                $body = str_replace($replacements[$i], $b, $body);
            }
        }
        return self::markdownConverter()->convert($body);
    }

    /**
     * @todo: test
     */
    public function frontMatter(): FrontMatter
    {
        if (! isset($this->frontMatter)) {
            $frontMatter = self::markdownConverter()
                ->getFrontMatter($this->fileContent());
            $this->frontMatter = FrontMatter::init($frontMatter);
        }
        return $this->frontMatter;
    }

    public function body(): string
    {
        if (strlen($this->body) === 0) {
            $this->body = self::markdownConverter()
                ->getBody($this->fileContent());
        }
        return $this->body;
    }

    public function pageTitle(): string
    {
        $titles   = [];
        $titles[] = $this->frontMatter()->title();

        $file = clone $this->file;
        while ($file->canGoUp()) {
            $file = $file->up();

            $m = Markdown::for($file);

            $titles[] = $m->frontMatter()->title();
        }

        $titles = array_filter($titles);
        return implode(' | ', $titles);
    }

    private function fileContent(): string
    {
        if (strlen($this->fileContent) === 0 and $this->file->found()) {
            $this->fileContent = $this->file->contents();
        }
        return $this->fileContent;
    }
}
