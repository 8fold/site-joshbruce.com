<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\CommonMarkPartials\PartialInterface;
use Eightfold\CommonMarkPartials\PartialInput;

use Eightfold\Amos\PlainText\PrivateFile;

class OriginalContentNotice implements PartialInterface
{
    private const COMPONENT_WRAPPER = '{!! platformlink !!}';

    private function originalNotice(): string
    {
        $path = $this->site()->contentRoot() . '/notices/original.md';
        if (file_exists($path) == false) {
            return '';
        }

        $content = file_get_contents($path);
        if ($content === false) {
            return '';
        }
        return $content;
    }

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

        $noticeMarkdown = PrivateFile::inRoot(
            $site->contentRoot(),
            'original.md',
            '/notices'
        );
        if ($noticeMarkdown->notFound()) {
            return '';
        }
        $noticeMarkdown = (string) $noticeMarkdown;

        $meta = $site->publicMeta($request_path);
        if (
            $meta->notFound() or
            $meta->hasProperty('original') === false
        ) {
            return '';
        }

        $metaOriginal = $meta->original();
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
