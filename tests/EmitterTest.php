<?php

use JoshBruce\Site\Emitter;

test('Exists', function () {
    expect(
        Emitter::create(200, 'Ok', 'Page found')->statusLine()
    )->toBe(
        'HTTP/2 200 Ok'
    );
});
