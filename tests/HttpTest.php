<?php
//
// declare(strict_types=1);
//
// use JoshBruce\Site\HttpResponse;
// use JoshBruce\Site\HttpRequest;
// use JoshBruce\Site\ServerGlobals;
//
// test('expected headers', function() {
//     expect(
//         HttpResponse::init(
//             with: HttpRequest::init()
//         )->headers()
//     )->toBeEmpty()->toBeArray();
// })->group('response', 'focus');
//
// test('expected body', function() {
//     expect(
//         HttpResponse::init(
//             with: HttpRequest::init()
//         )->body()
//     )->toBe(<<<text
//         Hello, World!
//         text
//     );
// })->group('response');
//
// test('correct status codes', function() {
//     serverGlobals();
//
//     expect(
//         HttpResponse::init(
//             with: HttpRequest::init()
//         )->statusCode()
//     )->toBeInt()->toBe(
//         200
//     );
//
//     unset($_SERVER['APP_ENV']);
//
//     expect(
//         HttpResponse::init(
//             with: HttpRequest::init()
//         )->statusCode()
//     )->toBeInt()->toBe(
//         500
//     );
//
//     $_SERVER['REQUEST_METHOD'] = 'post';
//
//     expect(
//         HttpResponse::init(
//             with: HttpRequest::init()
//         )->statusCode()
//     )->toBeInt()->toBe(
//         405
//     );
//
//     serverGlobals('/not-valid');
//
//     expect(
//         HttpResponse::init(
//             with: HttpRequest::init()
//         )->statusCode()
//     )->toBeInt()->toBe(
//         404
//     );
// })->group('response');
//
// test('can check request is valid', function() {
//     serverGlobals();
//
//     expect(
//         HttpRequest::init()->isMissingRequiredValues()
//     )->toBeFalse();
//
//     expect(
//         HttpRequest::init()->isUnsupportedMethod()
//     )->toBeFalse();
//
//     expect(
//         HttpRequest::init()->isNotFound()
//     )->toBeFalse();
//
//     serverGlobals('/not-valid');
//     unset($_SERVER['APP_ENV']);
//     $_SERVER['REQUEST_METHOD'] = 'post';
//
//     expect(
//         HttpRequest::init()->isMissingRequiredValues()
//     )->toBeTrue();
//
//     expect(
//         HttpRequest::init()->isUnsupportedMethod()
//     )->toBeTrue();
//
//     expect(
//         HttpRequest::init()->isNotFound()
//     )->toBeTrue();
// })->group('request');
//
// it('uses server globals', function() {
//     serverGlobals();
//
//     expect(
//         ServerGlobals::init()->hasAppEnv()
//     )->toBeTrue();
//
//     unset($_SERVER['APP_ENV']);
//
//     expect(
//         ServerGlobals::init()->hasAppEnv()
//     )->toBeFalse();
// })->group('globals');
