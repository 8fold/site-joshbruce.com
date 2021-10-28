<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Nyholm\Psr7\Factory\Psr17Factory as PsrFactory;
use Nyholm\Psr7\Response as PsrResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiStreamEmitter as PsrEmitter;

use Eightfold\HTMLBuilder\Document;
use Eightfold\Markdown\Markdown;

use JoshBruce\Site\Content;
use JoshBruce\Site\Server;

class Emitter
{
    /**
     * @param  array<string, string|string[]> $headers [description]
     */
    public static function emitWithResponse(
        int $status,
        array $headers,
        string $body = ''
    ): void {
        $factory  = new PsrFactory();
        $stream   = $factory->createStream($body);
        $response = new PsrResponse($status, $headers, $stream);
        self::emit($response);
    }

    /**
     * @param  array<string, string|string[]> $headers [description]
     */
    public static function emitWithResponseFile(
        int $status,
        array $headers,
        string $file
    ): void {
        $factory  = new PsrFactory();
        $stream   = $factory->createStreamFromFile($file);
        $response = new PsrResponse($status, $headers, $stream);
        self::emit($response);
    }

    public static function emit(PsrResponse $response): void
    {
        $emitter = new PsrEmitter();
        $emitter->emit($response);
    }

    public static function emitInterServerErrorResponse(
        Markdown $converter,
        string $projectRoot
    ): void {
        $content = Content::init($projectRoot, 0, '/setup-errors')
            ->for('/500.md');

        self::emitWithResponse(
            500,
            [
                'Cache-Control' => [
                    'no-cache',
                    'must-revalidate'
                ]
            ],
            Document::create(
                    $converter->getFrontMatter($content->markdown())['title']
                )->body(
                    $converter->convert($content->markdown())
                )->build()
        );
    }

    public static function emitUnsupportedMethodResponse(
        Markdown $converter,
        string $projectRoot,
        Server $server
    ): void {
        $content = Content::init($projectRoot, 0, '/setup-errors')
            ->for('/405.md');

        self::emitWithResponse(
            405,
            [
                'Cache-Control' => [
                    'no-cache',
                    'must-revalidate'
                ],
                'Allow' => $server->supportedMethods()
            ],
            Document::create(
                    $converter->getFrontMatter($content->markdown())['title']
                )->body(
                    $converter->convert($content->markdown())
                )->build()
        );
    }

    public static function emitBadGatewayResponse(
        Markdown $converter,
        string $projectRoot
    ): void {
        $content = Content::init($projectRoot, 0, '/setup-errors')
            ->for('/502.md');

        self::emitWithResponse(
            502,
            [
                'Cache-Control' => [
                    'no-cache',
                    'must-revalidate'
                ]
            ],
            Document::create(
                    $converter->getFrontMatter($content->markdown())['title']
                )->body(
                    $converter->convert($content->markdown())
                )->build()
        );
    }

    public static function emitNotFoundResponse(
        Markdown $converter,
        Content $localContent,
        string $path
    ): void {
        $content = $localContent->for(path: $path);
        self::emitWithResponse(
            404,
            [
                'Cache-Control' => [
                    'no-cache',
                    'must-revalidate'
                ]
            ],
            Document::create(
                    $converter->getFrontMatter($content->markdown())['title']
                )->body(
                    $converter->convert($content->markdown())
                )->build()
        );
    }

    public function emitRedirectionResponse(string $location): void
    {
        self::emitWithResponse(
            301,
            [
                'Location' => $location
            ]
        );
    }
}
