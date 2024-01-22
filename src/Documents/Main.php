<?php
declare(strict_types=1);

namespace JoshBruce\Site\Documents;

use Stringable;

use Eightfold\HTMLBuilder\Document;
use Eightfold\HTMLBuilder\Element;
use Eightfold\HTMLBuilder\Components\Favicons;
use Eightfold\HTMLBuilder\Components\Copyright;

use Eightfold\Amos\SiteInterface;
use Eightfold\Amos\FileSystem\Path;

use JoshBruce\Site\PageComponents\Navigation;
use JoshBruce\Site\PageComponents\Breadcrumbs;

class Main implements Stringable // Buildable
{
    private string $pageTitle = '';

    private string $body = '';

    private string $schemaType = 'BlogPosting';

    public static function create(SiteInterface $site, Path $requestPath): self
    {
        return new self($site, $requestPath);
    }

    final private function __construct(
        private readonly SiteInterface $site,
        private readonly Path $requestPath
    ) {
    }

    public function site(): SiteInterface
    {
        return $this->site;
    }

    public function requestPath(): Path
    {
        return $this->requestPath;
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

    public function __toString(): string
    {
        return (string) Document::create(
            $this->pageTitle()
        )->head(
            Element::meta()->omitEndTag()->props(
                'name viewport',
                'content width=device-width,initial-scale=1'
            ),
            // Element::meta()->omitEndTag()->props(
            //     'name description',
            //     'content A tabletop role playing game for the ages.'
            // ),
            Favicons::create(
                path: '/favicons',
                themeColor: '#ffffff',
            )->withSafariThemeColor('#00aba9')->withMetro('#00aba9'),
            Element::link()->omitEndTag()
                ->props(
                    'rel stylesheet',
                    'href /css/styles.min.css?v=1.3.2',
                    'type text/css'
                ),
            Element::script()->props(
                'src /js/interactive.min.js',
                'type text/javascript'
            ),
            Element::link()->omitEndTag()
                ->props(
                    'rel me',
                    'href https://phpc.social/@itsjoshbruce'
                )
        )->body(
            Element::a('Skip to main content')
                ->props('href #main', 'id skip-nav'),
            Navigation::create($this->site(), $this->requestPath()),
            Breadcrumbs::create($this->site(), $this->requestPath()),
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
                            'social'
                        )->props('href /support/')
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
        );
    }
}
