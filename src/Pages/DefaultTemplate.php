<?php

declare(strict_types=1);

namespace JoshBruce\Site\Pages;

use Eightfold\Markdown\Markdown as MarkdownConverter;
use Eightfold\HTMLBuilder\Element;
use Eightfold\HTMLBuilder\Document;

use JoshBruce\Site\FileSystem;
use JoshBruce\Site\Content\Markdown;
use JoshBruce\Site\PageComponents\Data;
use JoshBruce\Site\PageComponents\DateBlock;
use JoshBruce\Site\PageComponents\Footer;
use JoshBruce\Site\PageComponents\HeadElements;
use JoshBruce\Site\PageComponents\Heading;
use JoshBruce\Site\PageComponents\LogList;
use JoshBruce\Site\PageComponents\Navigation;
use JoshBruce\Site\PageComponents\OriginalContentNotice;

use JoshBruce\Site\Content\FrontMatter;

class DefaultTemplate
{
    private FrontMatter $frontMatter;

    private string $markdownBody = '';

    public static function create(
        FileSystem $file,
        MarkdownConverter $markdownConverter,
        Markdown $markdown
    ): DefaultTemplate {
        return new DefaultTemplate($file, $markdownConverter, $markdown);
    }

    public function __construct(
        private FileSystem $file,
        private MarkdownConverter $markdownConverter,
        private Markdown $markdown
    ) {
        $this->markdownConverter = $markdownConverter
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

    /**
     * @return array<string, string|string[]>
     */
    public function headers(): array
    {
        $headers = [];
        $headers['Content-Type'] = $this->file->mimeType();
        return $headers;
    }

    public function body(): string
    {
        $body = $this->markdown();
        $body = Data::create(frontMatter: $this->frontMatter()) .
            "\n\n" . $body;

        $originalLink = OriginalContentNotice::create(
            frontMatter: $this->frontMatter(),
            fileSystem: $this->file,
            // markdownConverter: $this->markdownConverter
        );
        $body = $originalLink . "\n\n" . $body;

        $body = DateBlock::create(frontMatter: $this->frontMatter()) .
            "\n\n" . $body;



        if ($this->file->isNotRoot()) {
            $body = Heading::create(frontMatter: $this->frontMatter()) .
                "\n\n" . $body;
        }

        $body = $body . "\n\n" . LogList::create(
            $this->frontMatter(),
            $this->file
        );

        return Document::create(
            $this->pageTitle()
        )->head(
            ...HeadElements::create()
        )->body(
            Element::a('menu')->props('href #main-nav', 'id content-top'),
            Element::article(
                $this->markdownConverter->convert($body)
            )->props('typeof BlogPosting', 'vocab https://schema.org/'),
            Element::a('top')->props('href #content-top', 'id go-to-top'),
            Navigation::create($this->file)->build(),
            Footer::create()
        )->build();
    }

    private function pageTitle(): string
    {
        $contents = $this->file->folderStack();
        $titles = [];
        foreach ($contents as $file) {
            $fileContent = $file->with(
                $file->folderPath(full: false),
                'content.md'
            );
            $titles[] = Markdown::init($fileContent)
                ->frontMatter()->title();
        }
        return implode(' | ', $titles);
    }

    private function markdown(): string
    {
        if (strlen($this->markdownBody) === 0) {
            $this->markdownBody = $this->markdownConverter->getBody(
                $this->markdown->markdown()
            );
        }
        return $this->markdownBody;
    }

    private function frontMatter(): FrontMatter
    {
        if (! isset($this->frontMatter)) {
            $frontMatter = $this->markdownConverter
                ->getFrontMatter($this->markdown->markdown());
            $this->frontMatter = FrontMatter::init($frontMatter);
        }
        return $this->frontMatter;
    }
}
