<?php
declare(strict_types=1);

namespace JoshBruce\Site\Documents;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\HTMLBuilder\Document;
use Eightfold\HTMLBuilder\Element;

use Eightfold\Amos\Site;

use Eightfold\Amos\PageComponents\Favicons;
use Eightfold\Amos\PageComponents\Copyright;

use JoshBruce\Site\PageComponents\Navigation;

class Main implements Buildable
{
    private string $pageTitle = '';

    private string $body = '';

    private string $schemaType = 'BlogPosting';

    public static function create(Site $site): self
    {
        return new self($site);
    }

    final private function __construct(private Site $site)
    {
    }

    public function site(): Site
    {
        return $this->site;
    }

    public function setPageTitle(string $title): self
    {
        $this->pageTitle = $title;
        return $this;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function setSchemaType(string $type): self
    {
        $this->schemaType = $type;
        return $this;
    }

    private function pageTitle(): string
    {
        return $this->pageTitle;
    }

    private function body(): string
    {
        return $this->body;
    }

    private function schemaType(): string
    {
        return $this->schemaType;
    }

    public function build(): string
    {
        return Document::create(
            $this->pageTitle()
        )->head(
            Element::meta()->omitEndTag()->props(
                'name viewport',
                'content width=device-width,initial-scale=1'
            ),
            Element::meta()->omitEndTag()->props(
                'name description',
                'content A tabletop role playing game for the ages.'
            ),
            Favicons::create(
                themeColor: '#ffffff',
                path: '/favicons',
                msAppTileColor: '#00aba9',
                safariTabColor: '#00aba9'
            ),
            Element::link()->omitEndTag()
                ->props(
                    'rel stylesheet',
                    'href /css/styles.min.css',
                    'type text/css'
                ),
            Element::script()->props(
                'src /js/interactive.min.js',
                'type text/javascript'
            )
        )->body(
            Element::a('Skip to main content')
                ->props('href #main', 'id skip-nav'),
            Navigation::create($this->site()),
            Element::article(
                Element::section(
                    $this->body()
                )->props(
                    'typeof ' . $this->schemaType(),
                    'vocab https://schema.org/'
                )
            )->props('id main', 'role main'),
            Element::footer(
                Element::ul(
                    Element::li(
                        Element::a(
                            'all content'
                        )->props('href /full-navigation/')
                    ),
                    Element::li(
                        Element::a(
                            'terms'
                        )->props('href /legal/')
                    ),
                    Element::li(
                        Element::a(
                            'support'
                        )->props('href /support/')
                    )
                ),
                Copyright::create('Joshua C. Bruce', '2004')
            ),
            Element::a(
                Element::span(
                    'to top'
                )
            )->props('id back-to-top', 'href #skip-nav')
        )->build();
    }

    public function __toString(): string
    {
        return $this->build();
    }
}
