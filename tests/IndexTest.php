<?php

use JoshBruce\Site\App;
use JoshBruce\Site\Environment;
use JoshBruce\Site\Server;

beforeEach(function() {
    serverGlobals();
});

test('App can respond positively and negatively', function() {
    expect(
        App::init(
            Environment::init(
                Server::init($_SERVER)
            )
        )->response()->isOk()
    )->toBeTrue();

    expect(
        App::init(
            Environment::init(
                Server::init($_SERVER)
            )
        )->response()->getStatusCode()
    )->toBe(
        200
    );

    $_SERVER['REQUEST_URI'] = '/does-not-exist';

    expect(
        App::init(
            Environment::init(
                Server::init($_SERVER)
            )
        )->response()->getStatusCode()
    )->toBe(
        404
    );
})->group('index');

test('Environment can respond positively and negatively', function() {
    expect(
        Environment::init(
            Server::init($_SERVER)
        )->response()->isOk()
    )->toBeTrue();

    expect(
        Environment::init(
            Server::init($_SERVER)
        )->response()->getStatusCode()
    )->toBe(
        200
    );

    $_SERVER['CONTENT_FOLDER'] = '/incorrect-folder-name';

    expect(
        Environment::init(
            Server::init($_SERVER)
        )->response()->getStatusCode()
    )->toBe(
        502
    );
})->group('index');

test('Server can respond positively and negatively', function() {
    expect(
        Server::init($_SERVER)->response()->isOk()
    )->toBeTrue();

    expect(
        Server::init($_SERVER)->response()->getStatusCode()
    )->toBe(
        200
    );

    unset($_SERVER['APP_ENV']);

    expect(
        Server::init($_SERVER)->response()->getStatusCode()
    )->toBe(
        500
    );
})->group('index');
