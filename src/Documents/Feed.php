<?php
declare(strict_types=1);

namespace JoshBruce\Site\Documents;

use DateTime;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use Nyholm\Psr7\Response;

use Symfony\Component\Finder\Finder as SymfonyFinder;

use Eightfold\Amos\Site;

use Eightfold\Syndication\Rss\Document as RssDocument;
use Eightfold\Syndication\Rss\Items as RssItems;
use Eightfold\Syndication\Rss\Item as RssItem;
use Eightfold\Syndication\Rss\Guid as RssGuid;

use Eightfold\Syndication\Atom\Document as AtomDocument;
use Eightfold\Syndication\Atom\Title as AtomTitle;
use Eightfold\Syndication\Atom\Links as AtomLinks;
use Eightfold\Syndication\Atom\Link as AtomLink;
use Eightfold\Syndication\Atom\Entries as AtomEntries;
use Eightfold\Syndication\Atom\Entry as AtomEntry;
use Eightfold\Syndication\Atom\Summary as AtomSummary;
use Eightfold\Syndication\Atom\Authors as AtomAuthors;
use Eightfold\Syndication\Atom\Author as AtomAuthor;

use Eightfold\Markdown\Markdown;

class Feed
{
    public const RSS  = 'rss';
    public const ATOM = 'atom';

    public function __invoke(
        Site $site,
        Markdown $converter,
        string $feedType = self::RSS
    ): Response {
        $iterator = (new SymfonyFinder())->files()->name('meta.json')
            ->in(
                $site->publicRoot()->toString()
            );

        $defaultAuthors = $site->publicMeta('/');
die(var_dump(
    $site->publicMeta()
));
        if (is_array($defaultAuthors) and count($defaultAuthors) > 0) {
            if ($feedType === self::ATOM) {
                $authors = [];
                foreach ($defaultAuthors as $author) {
                    die(var_dump(
                        $author
                    ));
                    $authors[] = AtomAuthor::create(

                    );
                }
            }
        }

        $toBeSorted = [];


        foreach ($iterator as $path) {
            $path    = $path->getRealPath();
            $uriPath = str_replace(
                ['meta.json', $site->publicRoot()],
                ['', ''],
                $path
            );

            $meta = $site->publicMeta($uriPath);
            if ($meta->updated() === false and $meta->created() === false) {
                continue;
            }

            $lastYear = (int) date('Ymd', strtotime('-52 weeks'));
            $pubDate  = ($meta->updated()) ? $meta->updated() : $meta->created();
            if ($pubDate < $lastYear) {
                continue;
            }
            $updatedDate = DateTime::createFromFormat(
                'YmdH:i:s',
                $pubDate . '12:00:00'
            );

            $content     = $site->publicContent($uriPath);
            $html        = $converter->convert($content->toString());
            $description = $this->description($html);
            if ($description === false) {
                continue;
            }

            $title = str_replace(
                    ['<p>', '</p>'],
                    ['', ''],
                    $converter->convert($meta->title())
                );

            $link = $site->domain() . $uriPath;

            if ($feedType === self::ATOM) {
                $item = AtomEntry::create(
                    title: AtomTitle::create($title),
                    updated: $updatedDate,
                    id: $link,
                    summary: AtomSummary::create($description),
                    links: AtomLinks::create(
                        AtomLink::create($link)
                    )
                );

            } else {
                $item =  RssItem::create(
                    title: $title,
                    description: $description
                )->withPubDate(
                    $updatedDate
                )->withGuid(
                    RssGuid::create($link)
                );

            }

            $toBeSorted[$pubDate][] = $item;
        }
        krsort($toBeSorted);

        $mostRecentUpdatedDate = array_key_first($toBeSorted);

        $items = array_merge(...array_values($toBeSorted));

        $title = $site->publicMeta('/')->title();
        if ($feedType === self::ATOM) {
            $link = $site->domain() . '/atom.xml';

            $document = AtomDocument::create(
                id: $link,
                title: AtomTitle::create($title),
                updated: DateTime::createFromFormat(
                    'YmdH:i:s',
                    $mostRecentUpdatedDate . '12:00:00'
                ),
                links: AtomLinks::create(
                    AtomLink::create($link)
                ),
                entries: AtomEntries::create($items[0])
            );



            return new Response(
                200,
                headers: [
                    'Content-Type' => 'application/xml',
                    'Charset' => 'utf-8'
                ],
                body: (string) AtomDocument::create(
                    id: $link,
                    title: AtomTitle::create($title),
                    updated: DateTime::createFromFormat(
                        'YmdH:i:s',
                        $mostRecentUpdatedDate . '12:00:00'
                    ),
                    links: AtomLinks::create(
                        AtomLink::create($link)
                    ),
                    entries: AtomEntries::create($items[0])
                )
            );
        }

        $link = $site->domain() . '/rss.xml';
        $description = $this->description(
                $converter->convert(
                    $site->publicContent('/')->toString()
                ),
                true
            );
        return new Response(
            200,
            headers: [
                'Content-Type' => 'application/xml',
                'Charset' => 'utf-8'
            ],
            body: (string) RssDocument::create(
                title: $title,
                link: $link,
                description: $description,
                items: RssItems::create(...$items)
            )
        );
    }

    private function description(
        string $from,
        bool $exclueEllipses = false
    ): string|false {
        $html = $from;

        $startChars = '<p>';
        $start      = strpos($html, $startChars);
        if ($start === false) {
            return false;
        }

        $endChars    = '</p>';
        $end         = strpos($html, $endChars);
        $description = strip_tags(substr(
            $html,
            $start,
            $end + strlen($endChars) - $start
        ));
        if (str_ends_with($description, ':')) {
            $description = rtrim($description, ':');
        }

        return ($exclueEllipses) ? $description : $description . ' ...';
    }
}
