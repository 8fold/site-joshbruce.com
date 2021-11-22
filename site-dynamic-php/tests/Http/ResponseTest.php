<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\Http\Response;

use JoshBruce\SiteDynamic\Http\Request;

use JoshBruce\SiteDynamic\FileSystem\Finder;

beforeEach(function() {
   if (array_key_exists('REQUEST_URI', $_SERVER)) {
       unset($_SERVER['REQUEST_URI']);
   }

   $_SERVER['REQUEST_METHOD'] = 'GET';
});

test('status codes', function() {
    // expect(
    //     Response::from(
    //         Request::fromGlobals(),
    //         in: Finder::init()
    //     )->getStatusCode()
    // )->toBeInt()->toBe(
    //     200
    // );

    $_SERVER['REQUEST_URI'] = '/something/invalid';

    expect(
        Response::from(
            Request::fromGlobals(),
            in: Finder::init()
        )->getStatusCode()
    )->toBeInt()->toBe(
        404
    );
//
//     unset($_SERVER['REQUEST_URI']);
//
//     $_SERVER['REQUEST_METHOD'] = 'POST';
//
//     expect(
//         Response::from(
//             Request::fromGlobals(),
//             in: Finder::init()
//         )->getStatusCode()
//     )->toBeInt()->toBe(
//         405
//     );
//
//     unset($_SERVER['REQUEST_METHOD']);
//     unset($_SERVER['APP_URL']);
//
//     expect(
//         Response::from(
//             Request::fromGlobals(),
//             in: Finder::init()
//         )->getStatusCode()
//     )->toBeInt()->toBe(
//         500
//     );
})->group('response', 'live-content');

test('can instantiate response', function() {
   expect(
       Response::from(
            Request::fromGlobals(),
            in: Finder::init()
       )
   )->toBeInstanceOf(
       Response::class
   );
})->group('response', 'live-content');
