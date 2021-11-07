<?php
//
// declare(strict_types=1);
//
// namespace JoshBruce\Site\PageComponents;
//
// use Eightfold\HTMLBuilder\Element as HtmlElement;
//
// use JoshBruce\Site\PageComponents\Favicons;
//
// class HeadElements
// {
//     /**
//      * @return array<int, HtmlElement>
//      */
//     public static function create(string $contentRoot): array
//     {
//         $headElements   = [
            // HtmlElement::meta()
            //     ->props('name viewport', 'content width=device-width,initial-scale=1')
//         ];
//
//         $headElements = array_merge($headElements, Favicons::create());
//
//         $cssPath  = '/assets/css/main.min.css';
//         // $filePath = $contentRoot . $cssPath;
//         // TODO: should be last commit of CSS file - another reason to place
//         //       content in same folder as rest of project.
//         $query = round(microtime(true));
//
//         $headElements[] = HtmlElement::link()
//             ->props('rel stylesheet', "href {$cssPath}?{$query}");
//         return $headElements;
//     }
// }
