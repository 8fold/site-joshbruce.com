<?php

declare(strict_types=1);

use Nyholm\Psr7\ServerRequest;

use JoshBruce\SiteDynamic\Http\RequestHandler;

use JoshBruce\SiteDynamic\FileSystem\Finder;
use JoshBruce\SiteDynamic\Environment;

afterEach(function() {
    foreach ($_ENV as $var => $value) {
        if ($var !== 'SHELL_VERBOSITY') {
            unset($_ENV[$var]);
            unset($_SERVER[$var]);
        }
    }
});

it('can find content', function() {
    expect(
        RequestHandler::in(
            Finder::init(),
            Environment::with(__DIR__ . '/../../../')
        )->handle(
            new ServerRequest(
                method: 'GET',
                uri: '/',
                headers: [],
                serverParams: $_SERVER
            )
        )->getStatusCode()
    )->toBe(
        200
    );

    $response = RequestHandler::in(
        Finder::init(),
        Environment::with(__DIR__ . '/../../../')
    )->handle(
        new ServerRequest(
            method: 'GET',
            uri: '/assets/css/main.min.css',
            headers: [],
            serverParams: $_SERVER
        )
    );

    expect(
        $response->getStatusCode()
    )->toBe(
        200
    );

    expect(
        $response->getHeaders()
    )->toBe([
        'Content-type' => ['text/css']
    ]);
})->group('request-handler', 'live-content', 'status-codes');

it('can return internal server error', function() {
    expect(
        RequestHandler::in(
            Finder::init(),
            Environment::with(__DIR__ . '/../test-project-root/failing-env')
        )->handle(
            new ServerRequest(
                method: 'GET',
                uri: '/',
                headers: [],
                serverParams: $_SERVER
            )
        )->getStatusCode()
    )->toBe(
        500
    );
})->group('request-handler', 'live-content', 'status-codes');

it('can return unsupported method', function() {
    expect(
        RequestHandler::in(
            Finder::init(),
            Environment::with(__DIR__ . '/../../../')
        )->handle(
            new ServerRequest(
                method: 'POST',
                uri: '/',
                headers: [],
                serverParams: $_SERVER
            )
        )->getStatusCode()
    )->toBe(
        405
    );
})->group('request-handler', 'live-content', 'status-codes');

it('can handle not found', function() {
    expect(
        RequestHandler::in(
            Finder::init(),
            Environment::with(__DIR__ . '/../../../')
        )->handle(
            new ServerRequest(
                method: 'GET',
                uri: '/does/not/exist',
                headers: [],
                serverParams: $_SERVER
            )
        )->getStatusCode()
    )->toBe(
        404
    );
})->group('request-handler', 'live-content', 'status-codes');

it('can handle redirect', function() {
    expect(
        RequestHandler::in(
            Finder::init(),
            Environment::with(__DIR__ . '/../../../')
        )->handle(
            new ServerRequest(
                method: 'GET',
                uri: '/self-improvement',
                headers: [],
                serverParams: $_SERVER
            )
        )->getStatusCode()
    )->toBe(
        301
    );
})->group('request-handler', 'live-content', 'status-codes');
