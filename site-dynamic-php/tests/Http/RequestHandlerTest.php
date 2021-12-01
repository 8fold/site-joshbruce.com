<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests\Http;

use JoshBruce\SiteDynamic\Tests\LiveContentTestCase;

use Nyholm\Psr7\ServerRequest;

use JoshBruce\SiteDynamic\Http\RequestHandler;

final class RequestHandlerTest extends LiveContentTestCase
{
    /**
     * @test
     *
     * @group live-content
     * @group request-handler
     * @group status-codes
     */
    public function test_ok_response(): void // phpcs:ignore
    {
        $this->assertSame(200, self::rootContentResponse()->getStatusCode());
    }

    /**
     * @test
     *
     * @group live-content
     * @group request-handler
     * @group status-codes
     */
    public function test_not_found_response(): void // phpcs:ignore
    {
        $invalidRequest = new ServerRequest(
            method: 'GET',
            uri: self::invalidPath(),
            headers: [],
            serverParams: $_SERVER
        );

        $statusCode = RequestHandler::in(self::liveContentEnv())
            ->handle($invalidRequest)->getStatusCode();

        $this->assertSame(404, $statusCode);
    }

    /**
     * @test
     *
     * @group live-content
     * @group request-handler
     * @group status-codes
     */
    public function test_file_response(): void // phpcs:ignore
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
