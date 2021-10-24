<?php

use JoshBruce\Site\App;

test('App exists', function() {
    expect(
        App::run()
    )->toBeInstanceOf(
        App::class
    )
});
