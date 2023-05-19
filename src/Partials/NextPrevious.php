<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\HTMLBuilder\Element;

use Eightfold\CommonMarkPartials\PartialInterface;
use Eightfold\CommonMarkPartials\PartialInput;

use Eightfold\Amos\Site;

class NextPrevious implements PartialInterface
{
    public function __invoke(
        PartialInput $input,
        array $extras = []
    ): string {
        if (
            array_key_exists('site', $extras) === false or
            array_key_exists('request_path', $extras) === false
        ) {
            return '';
        }

        $site         = $extras['site'];
        $request_path = $extras['request_path'];

        if (
            (is_object($site) === false or
            is_a($site, Site::class) === false) or
            is_string($request_path) === false
        ) {
            return '';
        }

        $path = $site->publicRoot() . $request_path;

        $pathParts = explode('/', $path);

        array_pop($pathParts);

        $folderName  = array_pop($pathParts);
        $folderAsInt = intval($folderName);

        $parentPath = implode('/', $pathParts);
        if (is_dir($parentPath) === false) {
            return '';
        }

        $contents = scandir($parentPath);

        if ($contents === false) {
            return '';
        }

        $foundCurrent = false;
        $previousPath     = '';
        $nextPath         = '';
        foreach ($contents as $content) {
            if (
                $content === '.' or
                $content === '..' or
                $content === '.DS_Store' or
                str_contains($content, '.')
            ) {
                continue;
            }

            if ($content === $folderName) {
                $foundCurrent = true;
                continue;
            }

            $contentAsInt = intval($content);

            if ($foundCurrent === false and $contentAsInt < $folderAsInt) {
                $previousPath = $parentPath . '/' . $content;
                continue;
            }

            if ($foundCurrent === true and $contentAsInt > $folderAsInt) {
                $nextPath = $parentPath . '/' . $content;
                break;
            }
        }

        $previous = '';
        if (strlen($previousPath) > 0) {
            list($root, $request) = explode('public', $previousPath, 2);
            $meta = $site->publicMeta(at: $request);
            if (
                $meta->notFound() === false and
                $meta->hasProperty('title')
            ) {
                $previous = Element::li(
                    Element::a($meta->title())->props('href ' . $request . '/')
                );
            }
        }

        $next = '';
        if (strlen($nextPath) > 0) {
            list($root, $request) = explode('public', $nextPath, 2);
            $meta = $site->publicMeta(at: $request);
            if (
                $meta->notFound() === false and
                $meta->hasProperty('title')
            ) {
                $next = Element::li(
                    Element::a($meta->title())->props('href ' . $request . '/')
                );
            }
        }

        return (string) Element::ul($previous, $next)->props('is next-previous');
    }
}
