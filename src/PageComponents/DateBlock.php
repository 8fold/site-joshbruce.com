<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Carbon\Carbon;

use Eightfold\HTMLBuilder\Element as HtmlElement;

class DateBlock
{
    /**
     * @param array<string, mixed> $frontMatter
     */
    public static function create(array $frontMatter): string
    {
        $updated = '';
        // FrontMatter::create()
        // $frontMatter->has('updated')
        // $frontMatter->updated()
        if (
            array_key_exists('updated', $frontMatter) and
            $carbon = Carbon::createFromFormat('Ymd', $frontMatter['updated'])
        ) {
            $time = HtmlElement::time($carbon->toFormattedDateString())
                ->props(
                    'property dateModified',
                    'content ' . $carbon->format('Y-m-d')
                )->build();
            $updated = HtmlElement::p("Updated on: {$time}");
        }

        $created = '';
        if (
            array_key_exists('created', $frontMatter) and
            $carbon = Carbon::createFromFormat('Ymd', $frontMatter['created'])
        ) {
            $time = HtmlElement::time($carbon->toFormattedDateString())
                ->props(
                    'property dateCreated',
                    'content ' . $carbon->format('Y-m-d')
                )->build();
            $created = HtmlElement::p("Created on: {$time}");
        }

        if (empty($updated) and empty($created)) {
            return '';
        }
        return HtmlElement::div($created, $updated)
            ->props('is dateblock')->build();
    }
}
