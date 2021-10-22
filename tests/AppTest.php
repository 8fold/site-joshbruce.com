<?php

declare(strict_types=1);

use JoshBruce\Site\App;

test('App returns expected content', function() {
    expect(
        App::run([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_SCHEME' => 'http',
            'REQUEST_URI'    => '/something/arbitrary',
            'HTTP_HOST'      => 'joshbruce.com',
            'SERVER_PORT'    => '8888',
            'CONTENT_UP'     => 0,
            'CONTENT_FOLDER' => 'site-joshbruce.com/tests/test-content'
        ])->response()->body()
    )->toBe(<<<html
        <!doctype html>
        <html lang="en"><head><title>Test main content</title><meta charset="utf-8"></head><body><p>The main content page for testing content.</p></body></html>
        html
    );

    expect(
        (string) App::run([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_SCHEME' => 'http',
            'REQUEST_URI'    => '/does-not-exist',
            'HTTP_HOST'      => 'joshbruce.com',
            'SERVER_PORT'    => '8888',
            'CONTENT_UP'     => 0,
            'CONTENT_FOLDER' => 'site-joshbruce.com/tests/test-content'
        ])->response()->body()
    )->toBe(<<<html
        <!doctype html>
        <html lang="en"><head><title>Page not found | Test main content</title><meta charset="utf-8"></head><body><p>Couldn't find the requested content.</p></body></html>
        html
    );
})->group('app');
