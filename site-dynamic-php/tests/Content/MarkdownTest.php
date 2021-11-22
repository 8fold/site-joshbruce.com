<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\Content\Markdown;

test('markdown converter singleton', function() {
    $converter1 = Markdown::markdownConverter();
    $converter2 = Markdown::markdownConverter();

    expect(
        $converter1
    )->toBe(
        $converter2
    );
})->group('markdown');
