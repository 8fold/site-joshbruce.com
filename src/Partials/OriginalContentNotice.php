<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\CommonMarkPartials\PartialInterface;
use Eightfold\CommonMarkPartials\PartialInput;

use Eightfold\Amos\Site;
use Eightfold\Amos\FileSystem\Path;
use Eightfold\Amos\FileSystem\Filename;
use Eightfold\Amos\PlainText\PrivateFile;

class OriginalContentNotice implements PartialInterface
{
    private const COMPONENT_WRAPPER = '{!! platformlink !!}';

    public function __invoke(
        PartialInput $input,
        array $extras = []
    ): string {
        if (
            array_key_exists('meta', $extras) === false or
            array_key_exists('site', $extras) === false
        ) {
            return '';
        }

        $meta = $extras['meta'];
        if (
            $meta->notFound() or
            $meta->hasProperty('original') === false
        ) {
            return '';
        }

        $site           = $extras['site'];
        $noticeMarkdown = PrivateFile::inRoot(
            $site->contentRoot(),
            Filename::fromString('original.md'),
            Path::fromString('notices')
        );
        if ($noticeMarkdown->notFound()) {
            return '';
        }

        $noticeMarkdown = (string) $noticeMarkdown;

        list($href, $platform) = explode(' ', $meta->original(), 2);

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
