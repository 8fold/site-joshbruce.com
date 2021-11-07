<?php
//
// declare(strict_types=1);
//
// namespace JoshBruce\Site\PageComponents;
//
// use Eightfold\Markdown\Markdown as MarkdownConverter;
//
// use Eightfold\HTMLBuilder\Element as HtmlElement;
//
// use JoshBruce\Site\FileSystem;
// use JoshBruce\Site\Content\Markdown;
// use JoshBruce\Site\Content\FrontMatter;
//
// class OriginalContentNotice
// {
//     public static function create(
//         string $copyContent,
//         string $messagePath,
//         string $originalLink
//     ): string {
//         if (empty($copyContent)) {
//             return '';
//         }
//
//         list($link, $platform) = explode(' ', $originalLink, 2);
//         $originalLink = HtmlElement::a($platform)
//             ->props("href {$link}", 'itemprop sameAs')
//             ->build();
//
//         $markdown = str_replace(
//             '{{platform link}}',
//             $originalLink,
//             $copyContent
//         );
//
//         return $markdown;
//     }
// }
