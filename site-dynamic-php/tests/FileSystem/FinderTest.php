<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\FileSystem\Finder;

use JoshBruce\SiteDynamic\Http\Request;

beforeEach(function() {
   if (array_key_exists('REQUEST_URI', $_SERVER)) {
       unset($_SERVER['REQUEST_URI']);
   }
});

test('there can be only one', function() {
    $finder1 = Finder::init();
    $finder2 = Finder::init();

    expect(
        $finder1
    )->toBe(
        $finder2
    );

    expect(
       Finder::init()
    )->toBeInstanceOf(
       Finder::class
    );
})->group('finder', 'live-content');

test('live content has expected folders', function() {
   expect(
       Finder::hasRequiredFolders()
   )->toBeTrue();
})->group('finder', 'live-content');

test('live content has expected published count', function() {
//    $expected = 42;
//
//    expect(
//        count(Finder::init())
//    )->toBe($expected);
//
//    expect(
//        Finder::init()->count()
//    )->toBe($expected);
})->group('finder', 'live-content');

test('live content has expected draft count', function() {
//    $expected = 9;
//
//    expect(
//        count(Finder::init()->draftContent())
//    )->toBe($expected);
//
//    expect(
//        Finder::init()->draftContent()->count()
//    )->toBe($expected);
})->group('finder', 'live-content');

test('live content has expected redirected count', function() {
//    $expected = 4;
//
//    expect(
//        count(Finder::init()->redirectedContent())
//    )->toBe($expected);
//
//    expect(
//        Finder::init()->redirectedContent()->count()
//    )->toBe($expected);
})->group('finder', 'live-content');

test('live content has expected files', function() {
    expect(
        Finder::fileForRequest(
            Request::fromGlobals()
        )->statusCode()
    )->toBeInt()->toBe(200);

    $_SERVER['REQUEST_URI'] = '/does/not/exist';

    expect(
        Finder::fileForRequest(
            Request::fromGlobals()
        )->statusCode()
    )->toBeInt()->toBe(400);

    $_SERVER['REQUEST_URI'] = '/assets/css/main.min.css';

    expect(
        Finder::fileForRequest(
            Request::fromGlobals()
        )->statusCode()
    )->toBeInt()->toBe(200);

    $_SERVER['REQUEST_URI'] = '/assets/favicons/favicon.ico';

    expect(
        Finder::fileForRequest(
            Request::fromGlobals()
        )->statusCode()
    )->toBeInt()->toBe(200);
})->group('finder', 'request', 'live-content', 'focus');

test('finder can determine existence of file', function() {
//     expect(
//         Finder::init()->fileNotFound(
//             Request::fromGlobals()
//         )
//     )->toBeFalse();
//
//     $_SERVER['REQUEST_URI'] = '/does/not/exist';
//
//     expect(
//         Finder::init()->fileNotFound(
//             Request::fromGlobals()
//         )
//     )->toBeTrue();
//
//     $_SERVER['REQUEST_URI'] = '/assets/css/main.min.css';
//
//     expect(
//         Finder::init()->fileNotFound(
//             Request::fromGlobals()
//         )
//     )->toBeFalse();
})->group('finder', 'live-content');
