<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\Http\Uri;

beforeEach(function() {
   if (array_key_exists('REQUEST_URI', $_SERVER)) {
       unset($_SERVER['REQUEST_URI']);
   }
});

test('can determine if file path', function() {
    expect(
        Uri::create('https://joshbruce.com')->isFile()
    )->toBeFalse();

    expect(
        Uri::create('https://joshbruce.com/assets/css/main.min.css')
            ->isFile()
    )->toBeTrue();
})->group('uri');
