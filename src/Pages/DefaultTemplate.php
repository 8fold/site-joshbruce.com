<?php

declare(strict_types=1);

namespace JoshBruce\Site\Pages;

use Eightfold\Markdown\Markdown as MarkdownConverter;
use Eightfold\HTMLBuilder\Element;
use Eightfold\HTMLBuilder\Document;

use JoshBruce\Site\FileSystem;
use JoshBruce\Site\Content\Markdown;
use JoshBruce\Site\PageComponents\Footer;
use JoshBruce\Site\PageComponents\HeadElements;
use JoshBruce\Site\PageComponents\Navigation;

use JoshBruce\Site\Content\FrontMatter;

class DefaultTemplate
{
    public static function create(
        string $body,
        string $mimeType, // should always be 'text/html'
        array $folderStack, // for page title
        FileSystem $file
    ): DefaultTemplate {
        return new DefaultTemplate($body, $mimeType, $folderStack, $file);
    }

    public function __construct(
        private string $body,
        private string $mimeType,
        private array $folderStack,
        // TODO:
        // passed to:
        //      navigation
        private FileSystem $file,
    ) {
    }

    /**
     * @return array<string, string|string[]>
     */
    public function headers(): array
    {
        $headers = [];
        $headers['Content-Type'] = $this->mimeType;
        return $headers;
    }

    public function body(): string
    {
        return Document::create(
            $this->pageTitle()
        )->head(
            ...HeadElements::create()
        )->body(
            Element::a('menu')->props('href #main-nav', 'id content-top'),
            Element::article(
                $this->body
            )->props('typeof BlogPosting', 'vocab https://schema.org/'),
            Element::a('top')->props('href #content-top', 'id go-to-top'),
            Navigation::create($this->file)->build(),
            Footer::create()
        )->build();
    }

    private function pageTitle(): string
    {
        $titles = [];
        foreach ($this->folderStack as $file) {
            $fileContent = $file->with(
                $file->folderPath(full: false),
                'content.md'
            );
            $titles[] = Markdown::init($fileContent)
                ->frontMatter()->title();
        }
        return implode(' | ', $titles);
    }
}
