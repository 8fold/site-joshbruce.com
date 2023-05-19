<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\CommonMarkPartials\PartialInterface;
use Eightfold\CommonMarkPartials\PartialInput;

use Eightfold\Amos\Site;
use Eightfold\Amos\PlainText\PrivateFile;

class OriginalContentNotice implements PartialInterface
{
    private const COMPONENT_WRAPPER = '{!! platformlink !!}';

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

        $meta = $site->publicMeta($request_path);
        if (
            $meta->notFound() or
            $meta->hasProperty('original') === false
        ) {
            return '';
        }

        $metaOriginal = $meta->original();

        // $path = $site->publicRoot() . $request_path;
        $noticeMarkdown = PrivateFile::inRoot(
            $site->contentRoot(),
            'original.md',
            '/notices'
        );
        if ($noticeMarkdown->notFound()) {
            return '';
        }

        $noticeMarkdown = (string) $noticeMarkdown;

        // $metaOriginal = $meta->original();
        list($href, $platform) = explode(' ', $metaOriginal, 2);

        $matches = [];
        $search  = '/' . self::COMPONENT_WRAPPER . '/';
        if (! preg_match($search, $noticeMarkdown, $matches)) {
            return '';
        }

        $noticeMarkdown = preg_replace(
            $search,
            "[{$platform}]({$href})",
            $noticeMarkdown
        );
        if ($noticeMarkdown === null) {
            return '';
        }

        return $noticeMarkdown;
    }
}
