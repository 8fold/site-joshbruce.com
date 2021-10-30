<?php

declare(strict_types=1);

namespace JoshBruce\Site\Pages;

use Eightfold\Markdown\Markdown;
use Eightfold\HTMLBuilder\Element;
use Eightfold\HTMLBuilder\Document;

use JoshBruce\Site\FileSystem;
use JoshBruce\Site\Content;
use JoshBruce\Site\PageComponents\Favicons;
use JoshBruce\Site\PageComponents\Navigation;
use JoshBruce\Site\PageComponents\DateBlock;
use JoshBruce\Site\PageComponents\Heading;
use JoshBruce\Site\PageComponents\LogList;
use JoshBruce\Site\PageComponents\Footer;

class DefaultTemplate
{
    /**
     * @var array<string, mixed>
     */
    private array $frontMatter = [];

    private string $markdownBody = '';

    public static function create(
        FileSystem $file,
        Markdown $markdownConverter,
        Content $content
    ): DefaultTemplate {
        return new DefaultTemplate($file, $markdownConverter, $content);
    }

    public function __construct(
        private FileSystem $file,
        private Markdown $markdownConverter,
        private Content $content
    ) {
        $this->markdownConverter = $markdownConverter
            ->withConfig(['html_input' => 'allow'])
            ->tables()->externalLinks();
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
        $body = DateBlock::create(frontMatter: $this->frontMatter()) . $body;
        $body = Heading::create(frontMatter: $this->frontMatter()) . "\n\n" .
            $body;

        $body = $body . "\n\n" . LogList::create(
            $this->frontMatter(),
            $this->file
        );

        $headElements   = Favicons::create();
        $headElements[] = Element::link()
            ->props('rel stylesheet', 'href /css/main.css');

        return Document::create(
            $this->pageTitle()
        )->head(
            ...$headElements
        )->body(
            Navigation::create($this->file)->build(),
            Element::article(
                $this->markdownConverter->convert($body)
            )->props('typeof BlogPosting', 'vocab https://schema.org/'),
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
            $titles[] = Content::init($fileContent)->frontMatter()['title'];
        }
        return implode(' | ', $titles);
    }

    private function markdown(): string
    {
        if (strlen($this->markdownBody) === 0) {
            $this->markdownBody = $this->markdownConverter->getBody(
                $this->content->markdown()
            );
        }
        return $this->markdownBody;
    }

    /**
     * @return array<string, mixed>
     */
    private function frontMatter(): array
    {
        if (count($this->frontMatter) === 0) {
            $this->frontMatter = $this->markdownConverter
                ->getFrontMatter($this->content->markdown());
        }
        return $this->frontMatter;
    }
}
