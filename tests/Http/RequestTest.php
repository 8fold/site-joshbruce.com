<?php

declare(strict_types=1);

use JoshBruce\Site\Http\Request;

use JoshBruce\Site\Http\Uri;

beforeEach(function() {
    $this->globalValues = [
        'REQUEST_SCHEME' => 'http',
        'REQUEST_URI'    => '/something/arbitrary',
        'HTTP_HOST'      => 'joshbruce.com',
        'SERVER_PORT'    => '8888'
    ];

    $this->request = Request::create(
        'get',
        Uri::create($this->globalValues)
    );
});

test('Uri can get parts', function() {
    expect(
        (string) $this->request->uri()
    )->toBe(
        'http://joshbruce.com:8888/something/arbitrary'
    );

    expect(
        $this->request->method()
    )->toBe(
        'get'
    );
})->group('request');
