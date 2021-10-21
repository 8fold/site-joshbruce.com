<?php

declare(strict_types=1);

use JoshBruce\Site\App;

test('App is stringable', function() {
    expect(
        (string) App::run()
    )->toBe(<<<html
        <!doctype html>
        <html lang="en"><head><title>Hello, World!</title><meta charset="utf-8"></head><body><p>Hello, World!</p></body></html>
        html
    );
});

test('App is startable', function() {
    expect(
        App::run()
    )->toBeInstanceOf(
        App::class
    );
});
