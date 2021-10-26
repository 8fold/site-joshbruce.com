<?php

use JoshBruce\Site\App;

test('Content can be in sub-folder', function() {
    $startTime = hrtime(true);

    $body = App::init(environment('/sub-folder'))->response()->getBody();

    $endTime = hrtime(true);

    $elapsed = $endTime - $startTime;
    $ms      = $elapsed/1e+6;

    expect($ms)->toBeLessThan(23);

    expect(
        $body
    )->toBe(<<<html
        <!doctype html>
        <html lang="en"><head><title>sub-folder | Josh Bruce's personal site</title><meta charset="utf-8"><link rel="stylesheet" href="/css/main.css"></link></head><body><h1>A sub-folder content</h1><p>This content was successfully found.</p></body></html>
        html
    );
});

test('Content is from file system', function() {
    $startTime = hrtime(true);

    $body = App::init(environment())->response()->getBody();

    $endTime = hrtime(true);

    $elapsed = $endTime - $startTime;
    $ms      = $elapsed/1e+6;

    expect($ms)->toBeLessThan(25);

    expect(
        $body
    )->toBe(<<<html
        <!doctype html>
        <html lang="en"><head><title>Josh Bruce's personal site</title><meta charset="utf-8"><link rel="stylesheet" href="/css/main.css"></link></head><body><h1>The domain of Josh Bruce</h1><p>This content was successfully found.</p></body></html>
        html
    );

    $startTime = hrtime(true);

    $body = App::init(environment('/does-not-exist'))->response()->getBody();

    $endTime = hrtime(true);

    $elapsed = $endTime - $startTime;
    $ms      = $elapsed/1e+6;

    expect($ms)->toBeLessThan(2);

    expect(
        $body
    )->toBe(<<<html
        <!doctype html>
        <html lang="en"><head><title>Not found</title><meta charset="utf-8"><link rel="stylesheet" href="/css/main.css"></link></head><body><h1>404: Not found</h1><p>We still haven’t found what you’re looking for.</p></body></html>
        html
    );
});

test('Instantiation', function () {
    expect(
        App::init(environment())->response()->getStatusCode()
    )->toBe(
        200
    );

    expect(
        App::init(environment('/does-not-exist'))->response()->getStatusCode()
    )->toBe(
        404
    );

    expect(
        App::init(environment())
    )->toBeInstanceOf(
        App::class
    );
})->group('app');
