<?php
declare(strict_types=1);

namespace Eightfold\Amos\Documents;

use SplFileInfo;

use Symfony\Component\Finder\Finder;

use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;

use Eightfold\Amos\Content;

/**
 * https://www.sitemaps.org
 *
 * Regarding priority: Some search engines, specifically Google, do not pay
 * much attention to priority (or lastmod). By default, we set all pages to 0.5.
 *
 * In your meta.json files, you can use the priority member to overwrite the
 * default. We recommend the following:
 *
 * 1.0-0.8: Homepage, product information, landing pages.
 * 0.7-0.4: News articles, some weather services, blog posts, pages that no site
 *          would be complete without.
 * 0.3-0.0: FAQs, outdated info, old press releases, completely static pages that
 *          are still relevant enough to keep from deleting entirely.
 */
class Sitemap
{
    public static function create(
        Content $contentIn,
        string $domain,
    ): self {
        return new self($contentIn, $domain);
    }

    final private function __construct(
        private Content $contentIn,
        private string $domain,
    ) {
    }

    private function content(): Content
    {
        return $this->contentIn;
    }

    private function domain(): string
    {
        return $this->domain;
    }

    public function build(): string
    {
        $metaFilePaths = (new Finder())->files()->name('meta.json')
            ->in($this->content()->publicContentRoot());

        $urls = [];
        foreach ($metaFilePaths as $metaFilePath) {
            $fullyQualifiedPath = $metaFilePath->getRealPath();
            $path = str_replace(
                [$this->content()->publicContentRoot(), '/meta.json'],
                ['', ''],
                $fullyQualifiedPath
            );

            $loc = $this->domain() . $path . '/';

            $meta = $this->content()->meta($path);

            $lastmod = '';
            if ($meta->valueExists(for: 'updated')) {
                $lastmod = $meta->value(for: 'updated');

            } elseif ($meta->valueExists(for: 'created')) {
                $lastmod = $meta->value(for: 'created');

            }
            $lastmod = date_format(date_create(strval($lastmod)), 'Y-m-d');

            $priority = 0.5;
            if ($meta->valueExists(for: 'priority')) {
                $priority = $meta->value(for: 'priority');

            }

            $urls[] = Element::url(
                Element::loc($loc),
                Element::lastmod($lastmod),
                Element::priority(strval($priority))
            );
        }

        return Document::urlset(
            ...$urls
        )->props('xmlns http://www.sitemaps.org/schemas/sitemap/0.9')->build();
    }

    public function __toString(): string
    {
        return $this->build();
    }
}
