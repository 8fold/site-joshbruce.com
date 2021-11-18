<?php

declare(strict_types=1);

namespace JoshBruce\Site\Documents;

use DateTime;

use Symfony\Component\Finder\Finder;

use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;
use Eightfold\XMLBuilder\Comment;
use Eightfold\XMLBuilder\Cdata;

use Eightfold\HTMLBuilder\Element as HtmlElement;

use JoshBruce\Site\FileSystemInterface;
use JoshBruce\Site\File;
use JoshBruce\Site\Content\Markdown;

class AtomFeed
{
    public static function create(File $file): string
    {
        $finder = self::finder($file->fileSystem());

        $dateFormat = 'Y-m-d\T00:00:00\Z';

        $markdownConverter = Markdown::markdownConverter();
        // $files = [];
        $entries = [];
        foreach ($finder as $found) {
            $localPath = $found->getPathname();
            $file      = File::at($localPath, $file->fileSystem());

            $date = $file->updated();
            if (! $date) {
                $date = $file->created();
            }

            $title   = $file->title();
            $link    = $file->canonicalUrl();
            $id      = $file->canonicalUrl();
            $summary = strip_tags($markdownConverter->convert(
                $file->description(400)
            ));
            $updated = $file->created($dateFormat);
            if ($file->frontMatterHasMember('updated')) {
                $updated = $file->updated($dateFormat);
            }

            $entries[$date] = Element::entry(
                Element::updated($updated),
                Element::title($title),
                Element::summary($summary),
                Element::link()->omitEndTag()->props(
                    "href {$link}",
                    "rel alternate"
                ),
                Element::id($id)
            );
        }
        krsort($entries);

        $feedUpdated = DateTime::createFromFormat(
            'Ymd',
            strval(array_key_first($entries))
        );
        if ($feedUpdated) {
            $feedUpdated = $feedUpdated->format($dateFormat);
        }

        return Document::feed(
            Element::updated($feedUpdated),
            // phpcs:ignore
            Comment::create('Copy the URL and paste into a feed reader; web or native application.'),
            Element::title('Personal site of Josh Bruce'),
            Element::author(
                Element::name('Joshua C. Bruce'),
                Element::email('josh@joshbruce.com')
            ),
            Element::link()->omitEndTag()->props(
                'rel self',
                'href https://joshbruce.com/atom-feed.xml'
            ),
            Element::link()->omitEndTag()->props(
                'href https://joshbruce.com/'
            ),
            Element::id('https://joshbruce.com/'),
            ...$entries
        )->props("xmlns http://www.w3.org/2005/Atom")->build();
    }

    private static function finder(FileSystemInterface $fileSystem): Finder
    {
        return $fileSystem->publishedContentFinder()->sortByName()
            ->notContains('redirect:')
            ->notContains('nofeed: true');
    }
}
