<?php

declare(strict_types=1);

use JoshBruce\Site\App;

test('App is startable', function() {
    expect(
        App::start()
    )->toBeInstanceOf(
        App::class
    );
});
