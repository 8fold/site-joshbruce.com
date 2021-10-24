<?php

use JoshBruce\Site\Emitter;

test('Instantiation', function () {
    expect(
        Emitter::create(
            200,
            'Ok',
            [
                'Cache-Control' => ['max-age=600']
            ]
        )->body()
    )->toBe(<<<html
        <!doctype html>
        <html>
            <head>
                <title>Josh Bruce's personal site</title>
                <style>
                    h1 {
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <h1>The domain of Josh Bruce</h1>
                <p>This content was successfully found.</p>
            </body>
        </html>
        html
    );

    expect(
        Emitter::create(
            500,
            'Internal server error',
            [
                'Cache-Control' => [
                    'no-cache',
                    'must-revalidate'
                ]
            ]
        )->headers()
    )->toBe(
        ['Cache-Control' => 'no-cache, must-revalidate']
    );

    expect(
        Emitter::create(200, 'Ok')->statusLine()
    )->toBe(
        'HTTP/2 200 Ok'
    );
})->group('emitter');
