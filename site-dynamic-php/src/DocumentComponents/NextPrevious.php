<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\DocumentComponents;

use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

use Eightfold\HTMLBuilder\Element;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\Content\Markdown;

class NextPrevious
{
    public static function create(
        PlainTextFile $file,
        Environment $environment
    ): string {
        $path = $file->path(omitFilename: true);

        $parts = explode('/', $path);
        array_pop($parts);
        $path = implode('/', $parts);

        $parentPath = implode('/', $parts);

        $finder = Finder::init($path, $environment->contentFilename())
            ->publishedContent();
        if (count($finder) === 0) {
            return '';
        }

        $previous = '';
        $next = '';

        $iterator = array_values(iterator_to_array($finder));
        for ($i = 0; $i < count($iterator); $i++) {
            $fileInfo = $iterator[$i];
            if ($fileInfo->getRealPath() === $file->path()) {
                if (array_key_exists($i - 1, $iterator)) {
                    $pInfo = $iterator[$i - 1];
                    $pFile = PlainTextFile::from($pInfo, $file->root());
                    $pHref = $pFile->path(full: false, omitFilename: true);
                    $previous = Element::li(
                        Element::a($pFile->title())->props('href ' . $pHref)
                    );

                }

                if (array_key_exists($i + 1, $iterator)) {
                    $nInfo = $iterator[$i + 1];
                    $nFile = PlainTextFile::from($nInfo, $file->root());

                    $pathCheck = $nFile->path(omitFilename: true);
                    if ($pathCheck !== $parentPath) {
                        $nHref = $nFile->path(full: false, omitFilename: true);
                        $next = Element::li(
                            Element::a($nFile->title())->props('href ' . $nHref)
                        );

                    }
                }
                break;
            }
        }

        return Element::ul($previous, $next)->props('is next-previous')->build();
    }
}
