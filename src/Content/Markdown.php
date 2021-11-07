<?php

declare(strict_types=1);

namespace JoshBruce\Site\Content;
//
// use DirectoryIterator;
//
use Eightfold\Markdown\Markdown as MarkdownConverter;

use JoshBruce\Site\File;

use JoshBruce\Site\PageComponents\Data;
use JoshBruce\Site\PageComponents\DateBlock;
// use JoshBruce\Site\PageComponents\Heading;
use JoshBruce\Site\PageComponents\LogList;
use JoshBruce\Site\PageComponents\OriginalContentNotice;

// use JoshBruce\Site\Content\FrontMatter;

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
        return implode(' | ', $titles);
    }

    private function fileContent(): string
    {
        if (strlen($this->fileContent) === 0 and $this->file->found()) {
            $this->fileContent = $this->file->contents();
        }
        return $this->fileContent;
    }
//
//     public function convert(): string
//     {
//         // TODO: cache as property
//         $body = self::markdownConverter()->getBody($this->markdown());
//
//         if ($this->frontMatter()->hasMember('data')) {
//             $body = Data::create(data: $this->frontMatter()->data()) .
//                 "\n\n" . $body;
//         }
//
//         $originalLink = '';
//         $original = $this->file->messages('original.md');
//         if (
//             $this->frontMatter()->hasMember('original') and
//             $original->found()
//         ) {
//             $copyContent = file_get_contents($original->path());
//             if (is_string($copyContent)) {
//                 $originalLink = OriginalContentNotice::create(
//                     copyContent: $copyContent,
//                     messagePath: $original->path(),
//                     originalLink: $this->frontMatter()->original()
//                 );
//             }
//         }
//
//         $body = $originalLink . "\n\n" . $body;
//
//         $dateBlock = DateBlock::create(frontMatter: $this->frontMatter());
//         if (strlen($dateBlock) > 0) {
//             $body = $dateBlock . "\n\n" . $body;
//         }
//
//         if ($this->file->isNotRoot()) {
//             // TODO: Not sure why this isn't working for static site
//             $body = Heading::create(frontMatter: $this->frontMatter()) .
//                 "\n\n" . $body;
//         }
//
//         if (
//             $this->frontMatter()->hasMember('type') and
//             $this->frontMatter()->type() === 'log'
//         ) {
//             $body = $body . "\n\n" . LogList::create(
//                 $this->file->subfolders('content.md')
//             );
//         }
//
//         return self::markdownConverter()->convert($body);
//     }
//
//     public function markdown(): string
//     {
//         if (strlen($this->markdown) === 0 and $this->file->found()) {
//             // $fileName = 'content.md';
//             // if (strlen($this->file->fileName()) > 0) {
//             //     $fileName = $this->file->fileName();
//             // }
//
//             $markdown = $this->file->contents();
//
//             // $markdown = file_get_contents(
//             //     $this->file->fileNamed($fileName)->path()
//             // );
//
//             if (is_bool($markdown)) {
//                 $markdown = '';
//             }
//
//             $this->markdown = $markdown;
//         }
//         return $this->markdown;
//     }
//

//
//     public function hasMoved(): bool
//     {
//         return strlen($this->redirectPath()) > 0;
//     }
//
//     public function redirectPath(): string
//     {
//         return $this->frontMatter()->redirectPath();
//     }
}
