<?php

declare(strict_types=1);

namespace JoshBruce\Site\Content;
//
// use DirectoryIterator;
//
use Eightfold\Markdown\Markdown as MarkdownConverter;
//
use JoshBruce\Site\File;
//
// use JoshBruce\Site\PageComponents\Data;
// use JoshBruce\Site\PageComponents\DateBlock;
// use JoshBruce\Site\PageComponents\Heading;
// use JoshBruce\Site\PageComponents\LogList;
// use JoshBruce\Site\PageComponents\OriginalContentNotice;
//
// use JoshBruce\Site\Content\FrontMatter;
//
class Markdown
{
    private string $fileContent = '';
//     private string $markdown = '';
//
//     /**
//      * @var FrontMatter
//      */
//     private FrontMatter $frontMatter;
//
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
        $body = self::markdownConverter()->getBody($this->fileContent());
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

    private function fileContent(): string
    {
        if (strlen($this->fileContent) === 0 and $this->file->found()) {
            $content = $this->file->contents();
            if (is_bool($content)) {
                $content = '';
            }
            $this->fileContent = $content;
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
