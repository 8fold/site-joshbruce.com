<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\FileSystem\Finder;

use JoshBruce\SiteDynamic\Http\Request;

beforeEach(function() {
   if (array_key_exists('REQUEST_URI', $_SERVER)) {
       unset($_SERVER['REQUEST_URI']);
   }
});

test('can instantiate live version', function() {
   expect(
       Finder::init()
   )->toBeInstanceOf(
       Finder::class
   );
})->group('finder', 'live-content');

test('live content has expected folders', function() {
   expect(
       Finder::init()->hasRequiredFolders()
   )->toBeTrue();
})->group('finder', 'live-content');

test('live content has expected published count', function() {
   $expected = 42;

   expect(
       count(Finder::init())
   )->toBe($expected);

   expect(
       Finder::init()->count()
   )->toBe($expected);
})->group('finder', 'live-content');

test('live content has expected draft count', function() {
   $expected = 9;

   expect(
       count(Finder::init()->draftContent())
   )->toBe($expected);

   expect(
       Finder::init()->draftContent()->count()
   )->toBe($expected);
})->group('finder', 'live-content');

test('live content has expected redirected count', function() {
   $expected = 4;

   expect(
       count(Finder::init()->redirectedContent())
   )->toBe($expected);

   expect(
       Finder::init()->redirectedContent()->count()
   )->toBe($expected);
})->group('finder', 'live-content');

test('live content has expected files', function() {
    expect(
        Finder::init()->publicFileForRequest(
            Request::fromGlobals(
                Finder::init()
            )
        )->path()
    )->toBe(
        Finder::init()->publicRoot() . '/content.md'
    );

    $_SERVER['REQUEST_URI'] = '/assets/css/main.min.css';

    expect(
        Finder::init()->publicFileForRequest(
            Request::fromGlobals(
                Finder::init()
            )
        )->path()
    )->toBe(
        Finder::init()->publicRoot() . '/assets/css/main.min.css'
    );
})->group('finder', 'request', 'live-content');
