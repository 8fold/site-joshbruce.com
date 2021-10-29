<?php

declare(strict_types=1);

namespace JoshBruce\Site\Pages;

use Eightfold\Markdown\Markdown;
use Eightfold\HTMLBuilder\Element;

use JoshBruce\Site\Content;

class DefaultTemplate
{
    private $frontMatter = [];

    private $markdownBody = '';

    public static function create(
        Markdown $markdownConverter,
        Content $content
    ): DefaultTemplate {
        return new DefaultTemplate($markdownConverter, $content);
    }

    public function __construct(
        private Markdown $markdownConverter,
        private Content $content
    ) {
        $this->markdownConverter = $markdownConverter
            ->withConfig(['html_input' => 'allow'])
            ->tables()->externalLinks();
    }

    public function headers(): array
    {
        $headers = [];
        $headers['Content-Type'] = $this->content->mimeType();
        return $headers;
    }

    public function body(): string
    {
        $body = $this->markdown();
        $body = $this->dateBlock() . $body;
        return $this->markdownConverter->convert($body);
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

    private function dateBlock(): string
    {
        $frontMatter = $this->frontMatter();
        $updated = '';
        if (array_key_exists('updated', $frontMatter)) {
            $updated = Element::p("Updated on: {$frontMatter['updated']}");
        }

        return Element::div(
                Element::p("Created on: {$frontMatter['created']}"),
                $updated
            )->props('is dateblock')->build();
    }

    private function frontMatter(): array
    {
        if (count($this->frontMatter) === 0) {
            $this->frontMatter = $this->markdownConverter
                ->getFrontMatter($this->content->markdown());
        }
        return $this->frontMatter;
    }


// $headElements   = JoshBruce\Site\PageComponents\Favicons::create();
// $headElements[] = Eightfold\HTMLBuilder\Element::link()
//     ->props('rel stylesheet', 'href /css/main.css');

// if (array_key_exists('header', $frontMatter)) {
//     $body = "# {$frontMatter['header']}\n\n" . $body;

// } else {
//     $body = "# {$frontMatter['title']}\n\n" . $body;

// }

// if (array_key_exists('type', $frontMatter) and $frontMatter['type'] === 'log') {
//     $contents = $content->contentInSubfolders();
//     krsort($contents);
//     $logLinks = [];
//     foreach ($contents as $key => $c) {
//         if (! str_starts_with(strval($key), '_') and $c->exists()) {
//             $logLinks[] = Eightfold\HTMLBuilder\Element::li(
//                 Eightfold\HTMLBuilder\Element::a(
//                     $c->frontMatter()['title']
//                 )->props('href ' . $c->pathWithoutFile())
//             );
//         }
//     }
//     $list = Eightfold\HTMLBuilder\Element::ul(...$logLinks)->build();
//     $body = $body . $list;
// }

// $body = Eightfold\HTMLBuilder\Document::create(
//         $frontMatter['title']
//     )->head(
//         ...$headElements
//     )->body(
//         JoshBruce\Site\PageComponents\Navigation::create($content)
//             ->build(),
//         $markdownConverter->convert($body),
//         Eightfold\HTMLBuilder\Element::footer(
//             Eightfold\HTMLBuilder\Element::p(
//                 'Copyright © 2004–' . date('Y') . 'Joshua C. Bruce. ' .
//                     'All rights reserved.'
//             )
//         )
//     )->build();
}
