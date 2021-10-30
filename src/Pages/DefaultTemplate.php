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

        $body = $body . "\n\n" . $this->logList();

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
            Element::footer(
                Element::p(
                    'Copyright © 2004–' . date('Y') . 'Joshua C. Bruce. ' .
                        'All rights reserved.'
                )
            )
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

    private function logList(): string
    {
        $frontMatter = $this->frontMatter();
        if (
            array_key_exists('type', $frontMatter) and
            $frontMatter['type'] === 'log'
        ) {
            $contents = $this->file->subfolders('content.md');
            krsort($contents);
            $logLinks = [];
            foreach ($contents as $key => $file) {
                if (! str_starts_with(strval($key), '_') and $file->found()) {
                    $content = Content::init($file);

                    $logLinks[] = Element::li(
                        Element::a(
                            $content->frontMatter()['title']
                        )->props('href ' . $file->folderPath(full: false))
                    );
                }
            }
            return Element::ul(...$logLinks)->build();
        }
        return '';
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
