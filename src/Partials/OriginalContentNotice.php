<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use Eightfold\CommonMarkPartials\PartialInterface;
use Eightfold\CommonMarkPartials\PartialInput;

use Eightfold\Amos\SiteInterface;
use Eightfold\Amos\FileSystem\Path;
use Eightfold\Amos\FileSystem\Filename;
use Eightfold\Amos\PlainText\PrivateFile;
use Eightfold\Amos\ObjectsFromJson\PublicMeta;

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

        $orignal = '';
        $meta    = $extras['meta'];
        if (
            is_object($meta) and
            is_a($meta, PublicMeta::class) and
            $meta->found() and
            $meta->hasProperty('original')
        ) {
            $orignal = $meta->original();

        } else {
            return '';

        }

        $noticeMarkdown = '';
        $site           = $extras['site'];
        if (is_object($site) and $site instanceof SiteInterface) {
            $noticeMarkdown = (string) PrivateFile::inRoot(
                $site->contentRoot(),
                Filename::fromString('original.md'),
                Path::fromString('notices')
            );
        }

        if (empty($noticeMarkdown)) {
            return '';
        }

        list($href, $platform) = explode(' ', $orignal, 2);

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
