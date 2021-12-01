<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Documents;

use DateTime;

// use Symfony\Component\Finder\Finder;

use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;
use Eightfold\XMLBuilder\Comment;
use Eightfold\XMLBuilder\Cdata;

use Eightfold\HTMLBuilder\Element as HtmlElement;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use JoshBruce\SiteDynamic\Content\Markdown;

class AtomFeed
{
    public static function create(
        PlainTextFile $file,
        Environment $environment
    ): string {
        $publicRoot = $environment->contentPublic();
        $finder = Finder::init($publicRoot, $environment->contentFilename())
            ->publishedContent();

        $dateFormat = 'Y-m-d\T00:00:00\Z';

        $markdownConverter = Markdown::markdownConverter();
        $updatedDates = [];
        foreach ($finder as $found) {
            $localPath = $found->getPathname();
            $file      = PlainTextFile::at($localPath, $publicRoot);

            $date = $file->updated();
            if (! $date) {
                $date = $file->created();
            }

            $title   = $file->title();
            $link    = $file->canonicalUrl($environment->appUrl());
            if (! str_ends_with($link, '/')) {
                $link = $link . '/';
            }
            $id      = $file->canonicalUrl($environment->appUrl());
            if (! str_ends_with($id, '/')) {
                $id = $id . '/';
            }
            $summary = strip_tags($markdownConverter->convert(
                $file->description(400)
            ));
            $updated = $file->created($dateFormat);
            if ($file->hasMetadata('updated')) {
                $updated = $file->updated($dateFormat);
            }

            $updatedDates[$date][] = Element::entry(
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
        krsort($updatedDates);

        $entries = [];
        foreach ($updatedDates as $updated) {
            foreach ($updated as $entry) {
                $entries[] = $entry;
            }
        }

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

    public static function finder(FileSystemInterface $fileSystem): Finder
    {
        return $fileSystem->publishedContentFinder()->sortByName()
            ->notContains('redirect:')
            ->notContains('nofeed: true');
    }
}
