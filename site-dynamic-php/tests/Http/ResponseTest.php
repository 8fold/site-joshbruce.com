<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\Http\Response;

use JoshBruce\SiteDynamic\Http\Request;

use JoshBruce\SiteDynamic\FileSystem\Finder;

beforeEach(function() {
   if (array_key_exists('REQUEST_URI', $_SERVER)) {
       unset($_SERVER['REQUEST_URI']);
   }
});

test('status codes', function() {
    expect(
        Response::from(
            Request::fromGlobals(),
            in: Finder::init()
        )->getStatusCode()
    )->toBeInt()->toBe(
        200
    );

    $_SERVER['REQUEST_URI'] = '/something/invalid';

    expect(
        Response::from(
            Request::fromGlobals(),
            in: Finder::init()
        )->getStatusCode()
    )->toBeInt()->toBe(
        404
    );

    unset($_SERVER['REQUEST_URI']);

    $_SERVER['REQUEST_METHOD'] = 'POST';

    expect(
        Response::from(
            Request::fromGlobals(),
            in: Finder::init()
        )->getStatusCode()
    )->toBeInt()->toBe(
        405
    );

    unset($_SERVER['REQUEST_METHOD']);
    unset($_SERVER['APP_URL']);

    expect(
        Response::from(
            Request::fromGlobals(),
            in: Finder::init()
        )->getStatusCode()
    )->toBeInt()->toBe(
        500
    );
//
//     expect(
//         HttpResponse::from(
//             request: HttpRequest::with(
//                 ServerGlobals::init()->withRequestUri('/published-redirect'),
//                 TestFileSystem::init()
//             )
//         )->statusCode()
//     )->toBeInt()->toBe(
//         301
//     );
//
//     expect(
//         HttpResponse::from(
//             request: HttpRequest::with(
//                 ServerGlobals::init()->withRequestUri('/published-redirect/302'),
//                 TestFileSystem::init()
//             )
//         )->statusCode()
//     )->toBeInt()->toBe(
//         302
//     );
//
//     $headers = HttpResponse::from(
//         request: HttpRequest::with(
//             ServerGlobals::init()->withRequestUri('/published-redirect/302'),
//             TestFileSystem::init()
//         )
//     )->headers();
//
//     expect(
//         array_key_exists('Location', $headers)
//     )->toBeTrue();
//
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
