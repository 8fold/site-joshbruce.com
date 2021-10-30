<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Nyholm\Psr7\Factory\Psr17Factory as PsrFactory;
use Nyholm\Psr7\Response as PsrResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiStreamEmitter as PsrEmitter;

use Eightfold\HTMLBuilder\Document;
use Eightfold\Markdown\Markdown;

use JoshBruce\Site\Server;
use JoshBruce\Site\FileSystem;
use JoshBruce\Site\Content;

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

    public static function emitFile(string $mimeType, string $filePath): void
    {
        self::emitWithResponseFile(
            200,
            [
                'Cache-Control' => ['max-age=2592000'],
                'Content-Type'  => $mimeType
            ],
            $filePath
        );
    }

    public static function emitInteralServerErrorResponse(
        Markdown $converter,
        string $projectRoot
    ): void {
        $file = FileSystem::init(
            $projectRoot,
            0,
            '/setup-errors',
            '',
            '500.md'
        );
        $content = Content::init($file);

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
        $file = FileSystem::init(
            $projectRoot,
            0,
            '/setup-errors',
            '',
            '405.md'
        );
        $content = Content::init($file);

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

    public static function emitBadContentResponse(
        Markdown $converter,
        string $projectRoot
    ): void {
        $file = FileSystem::init(
            $projectRoot,
            0,
            '/setup-errors',
            '',
            '500_2.md'
        );
        $content = Content::init($file);

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
        FileSystem $file
    ): void {
        $content = Content::init($file);

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

    public static function emitRedirectionResponse(string $location): void
    {
        self::emitWithResponse(
            301,
            [
                'Location' => $location,
                'Cache-Control' => [
                    'no-cache',
                    'must-revalidate'
                ]
            ]
        );
    }
}
