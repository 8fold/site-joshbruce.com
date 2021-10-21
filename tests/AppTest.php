<?php

declare(strict_types=1);

use JoshBruce\Site\App;

test('App returns expected content', function() {
    expect(
        (string) App::run([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/',
            'CONTENT_UP'     => 0,
            'CONTENT_FOLDER' => 'site-joshbruce.com/tests/test-content'
        ])
    )->toBe(<<<html
        <!doctype html>
        <html lang="en"><head><title>Test main content</title><meta charset="utf-8"></head><body><p>The main content page for testing content.</p>
        </body></html>
        html
    );

    expect(
        (string) App::run([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/does-not-exist',
            'CONTENT_UP'     => 0,
            'CONTENT_FOLDER' => 'site-joshbruce.com/tests/test-content'
        ])
    )->toBe(<<<html
        <!doctype html>
        <html lang="en"><head><title>Page not found | Test main content</title><meta charset="utf-8"></head><body><p>Couldn't find the requested content.</p>
        </body></html>
        html
    );
});
