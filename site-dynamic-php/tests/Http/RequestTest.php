<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\Http\Request;

use JoshBruce\SiteDynamic\FileSystem\Finder;

beforeEach(function() {
   if (array_key_exists('REQUEST_URI', $_SERVER)) {
       unset($_SERVER['REQUEST_URI']);
   }
});

test('can tell between file request and content', function() {
   expect(
       Request::fromGlobals(
           // Finder::init()
       )->isRequestingContent()
   )->toBeTrue();

   expect(
       Request::fromGlobals(
           // Finder::init()
       )->isRequestingFile()
   )->toBeFalse();


   $_SERVER['REQUEST_URI'] = '/assets/css/main.min.css';

   expect(
       Request::fromGlobals(
           // Finder::init()
       )->isRequestingContent()
   )->toBeFalse();

   expect(
       Request::fromGlobals(
           // Finder::init()
       )->isRequestingFile()
   )->toBeTrue();
})->group('request', 'live-content');

test('request implements interface', function() {
    expect(
        Request::fromGlobals(
            // Finder::init()
        )->getUri()->getPath()
    )->toBe(
        ''
    );

    $_SERVER['REQUEST_URI'] = '/legal';

    expect(
        Request::fromGlobals(
            // Finder::init()
        )->getUri()->getPath()
    )->toBe(
        '/legal'
    );

    expect(
        Request::fromGlobals(
            // Finder::init()
        )->getMethod()
    )->toBe(
        'GET'
    );

    expect(
        Request::fromGlobals(
            // Finder::init()
        )->withMethod('HEAD')->getMethod()
    )->toBe(
        'HEAD'
    );

    expect(
       Request::fromGlobals(
           // Finder::init()
       )
    )->toBeInstanceOf(
       Request::class
    );
})->group('request', 'live-content');
