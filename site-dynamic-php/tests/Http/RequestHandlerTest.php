<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests;

use JoshBruce\SiteDynamic\Tests\LiveContentTestCase;

use JoshBruce\SiteDynamic\Http\RequestHandler;

use Nyholm\Psr7\ServerRequest;

use JoshBruce\SiteDynamic\Environment;

final class RequestHandlerTest extends LiveContentTestCase
{
    public static function liveContentEnv(): Environment
    {
        return Environment::with(
            self::pathToContentPublic(),
            __DIR__ . '/../../public',
            'http://test.joshbruce',
            'test'
        );
    }

    /**
     * @test
     *
     * @group live-content
     * @group request-handler
     * @group status-codes
     */
    public function test_ok_response(): void
    {
        $rootRequest = new ServerRequest(
            method: 'GET',
            uri: '/',
            headers: [],
            serverParams: $_SERVER
        );

        $statusCode = RequestHandler::in(self::liveContentEnv())
            ->handle($rootRequest)->getStatusCode();

        $this->assertSame(200, $statusCode);
    }

    /**
     * @test
     *
     * @group live-content
     * @group request-handler
     * @group status-codes
     */
    public function test_not_found_response(): void
    {
        $rootRequest = new ServerRequest(
            method: 'GET',
            uri: self::invalidPath(),
            headers: [],
            serverParams: $_SERVER
        );

        $statusCode = RequestHandler::in(self::liveContentEnv())
            ->handle($rootRequest)->getStatusCode();

        $this->assertSame(404, $statusCode);
    }

    /**
     * @test
     *
     * @group live-content
     * @group request-handler
     * @group status-codes
     */
    public function test_file_response(): void
    {
        $rootRequest = new ServerRequest(
            method: 'GET',
            uri: '/assets/css/main.min.css',
            headers: [],
            serverParams: $_SERVER
        );

        $headers = RequestHandler::in(self::liveContentEnv())
            ->handle($rootRequest)->getHeaders();

        $this->assertSame(
            ['Content-type' =>
                ['text/css']
            ],
            $headers
        );
    }
}
