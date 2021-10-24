<?php

use JoshBruce\Site\App;

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
