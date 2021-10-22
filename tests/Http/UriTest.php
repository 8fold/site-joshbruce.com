<?php

declare(strict_types=1);

use JoshBruce\Site\Http\Uri;

beforeEach(function() {
    $this->globalValues = [
        'REQUEST_SCHEME' => 'http',
        'REQUEST_URI'    => '/something/arbitrary',
        'HTTP_HOST'      => 'joshbruce.com',
        'SERVER_PORT'    => '8888'
    ];
});

test('Uri can get parts', function() {
    expect(
        (string) Uri::create($this->globalValues)
    )->toBe(
        'http://joshbruce.com:8888/something/arbitrary'
    );
})->group('uri');
