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

use Eightfold\Markdown\Markdown;

class Feed
{
    public const RSS = 'rss';

    public function __invoke(
        Site $site,
        Markdown $converter,
        string $type = self::RSS
    ): Response {
        $iterator = (new SymfonyFinder())->files()->name('meta.json')
            ->in(
                $site->publicRoot()->toString()
            );

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


            $item =  RssItem::create(
                title: $title,
                description: $description
            )->withPubDate(
                DateTime::createFromFormat('YmdH:i:s', $pubDate . '12:00:00')
            )->withGuid(
                RssGuid::create(
                    $site->domain() . $uriPath
                )
            );

            $toBeSorted[$pubDate][] = $item;
        }
        krsort($toBeSorted);

        $items = array_merge(...array_values($toBeSorted));

        return new Response(
            200,
            headers: [
                'Content-Type' => 'text/xml',
                'Charset' => 'utf-8'
            ],
            body: (string) RssDocument::create(
                title: $site->publicMeta('/')->title(),
                link: $site->domain() . '/rss.xml',
                description: $this->description(
                    $converter->convert(
                        $site->publicContent('/')->toString()
                    ),
                    true
                ),
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
