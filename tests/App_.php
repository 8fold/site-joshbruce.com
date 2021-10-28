<?php

use JoshBruce\Site\App;

test('Content can be in sub-folder', function() {
    $startTime = hrtime(true);

    $body = App::init(environment('/sub-folder'))->response()->getBody();

    $endTime = hrtime(true);

    $elapsed = $endTime - $startTime;
    $ms      = $elapsed/1e+6;

    expect($ms)->toBeLessThan(306); // used to be 29ms

    expect(
        $body
    )->toBe(<<<html
        <!doctype html>
        <html lang="en"><head><title>sub-folder | Josh Bruce's personal site</title><meta charset="utf-8"><link type="image/x-icon" rel="icon" href="/assets/favicons/favicon.ico"></link><link rel="apple-touch-icon" href="/assets/favicons/apple-touch-icon.png" sizes="180x180"></link><link rel="image/png" href="/assets/favicons/favicon-32x32.png" sizes="32x32"></link><link rel="image/png" href="/assets/favicons/favicon-16x16.png" sizes="16x16"></link><link rel="stylesheet" href="/css/main.css"></link></head><body><nav><ul><li><a href="/">home</a></li><li><a href="/finances">Finances</a><ul><li><a href="/finances/investment-policy">Investment policy</a></li><li><a href="/finances/building-wealth-paycheck-to-paycheck">Paycheck to paycheck</a></li></ul></li><li><a href="/design-your-life">Design your life</a><ul><li><a href="/design-your-life/motivators">Motivators</a></li></ul></li><li><a href="/software-development">Software development</a><ul><li><a href="/software-development/why-dont-you-use">Why don't you use</a></li></ul></li></ul></nav><h1>A sub-folder content</h1><p>This content was successfully found.</p></body></html>
        html
    );
});

test('Content is from file system', function() {
    $startTime = hrtime(true);

    $body = App::init(environment())->response()->getBody();

    $endTime = hrtime(true);

    $elapsed = $endTime - $startTime;
    $ms      = $elapsed/1e+6;

    expect($ms)->toBeLessThan(67); // used to be 22ms

    expect(
        $body
    )->toBe(<<<html
        <!doctype html>
        <html lang="en"><head><title>Josh Bruce's personal site</title><meta charset="utf-8"><link type="image/x-icon" rel="icon" href="/assets/favicons/favicon.ico"></link><link rel="apple-touch-icon" href="/assets/favicons/apple-touch-icon.png" sizes="180x180"></link><link rel="image/png" href="/assets/favicons/favicon-32x32.png" sizes="32x32"></link><link rel="image/png" href="/assets/favicons/favicon-16x16.png" sizes="16x16"></link><link rel="stylesheet" href="/css/main.css"></link></head><body><nav><ul><li><a href="/">home</a></li><li><a href="/finances">Finances</a><ul><li><a href="/finances/investment-policy">Investment policy</a></li><li><a href="/finances/building-wealth-paycheck-to-paycheck">Paycheck to paycheck</a></li></ul></li><li><a href="/design-your-life">Design your life</a><ul><li><a href="/design-your-life/motivators">Motivators</a></li></ul></li><li><a href="/software-development">Software development</a><ul><li><a href="/software-development/why-dont-you-use">Why don't you use</a></li></ul></li></ul></nav><h1>The domain of Josh Bruce</h1><p>This content was successfully found.</p></body></html>
        html
    );

    $startTime = hrtime(true);

    $body = App::init(environment('/does-not-exist'))->response()->getBody();

    $endTime = hrtime(true);

    $elapsed = $endTime - $startTime;
    $ms      = $elapsed/1e+6;

    expect($ms)->toBeLessThan(5);

    expect(
        $body
    )->toBe(<<<html
        <!doctype html>
        <html lang="en"><head><title>Not found</title><meta charset="utf-8"><link type="image/x-icon" rel="icon" href="/assets/favicons/favicon.ico"></link><link rel="apple-touch-icon" href="/assets/favicons/apple-touch-icon.png" sizes="180x180"></link><link rel="image/png" href="/assets/favicons/favicon-32x32.png" sizes="32x32"></link><link rel="image/png" href="/assets/favicons/favicon-16x16.png" sizes="16x16"></link><link rel="stylesheet" href="/css/main.css"></link></head><body><nav><ul><li><a href="/">home</a></li><li><a href="/finances">Finances</a><ul><li><a href="/finances/investment-policy">Investment policy</a></li><li><a href="/finances/building-wealth-paycheck-to-paycheck">Paycheck to paycheck</a></li></ul></li><li><a href="/design-your-life">Design your life</a><ul><li><a href="/design-your-life/motivators">Motivators</a></li></ul></li><li><a href="/software-development">Software development</a><ul><li><a href="/software-development/why-dont-you-use">Why don't you use</a></li></ul></li></ul></nav><h1>404: Not found</h1><p>We still haven’t found what you’re looking for.</p></body></html>
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
