<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests;

use PHPUnit\Framework\TestCase;

use SplFileInfo;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Nyholm\Psr7\ServerRequest;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\Http\RequestHandler;

use JoshBruce\SiteDynamic\FileSystem\File;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

abstract class LiveContentTestCase extends TestCase
{
    public static function pathToContentPublic(): string
    {
        return __DIR__ . '/../../content/public';
    }

    public static function rootContentFile(): PlainTextFile
    {
        return PlainTextFile::at(
            self::pathToContentPublic() . '/content.md',
            self::pathToContentPublic(),
        );
    }

    public static function thisSiteContentFile(): PlainTextFile
    {
        return PlainTextFile::at(
            self::pathToContentPublic() . '/web-development/this-site/content.md',
            self::pathToContentPublic()
        );
    }

    public static function thisInternetBandwidthContentFile(): PlainTextFile
    {
        return PlainTextFile::at(
            self::pathToContentPublic() . '/web-development/on-constraints/internet-bandwidth/content.md', // phpcs:ignore
            self::pathToContentPublic()
        );
    }

    public static function pathToIndexRelative(): string
    {
        return __DIR__ . '/../public/index.php';
    }

    public static function pathToIndex(): string
    {
        $file  = new SplFileInfo(self::pathToIndexRelative());
        $path  =  $file->getRealPath();
        if (! $path) {
            return '';
        }
        return $path;
    }

    public static function invalidPath(): string
    {
        return '/does/not/ex/ist';
    }

    public static function liveContentEnv(): Environment
    {
        return Environment::with(
            self::pathToContentPublic(),
            __DIR__ . '/../../public',
            'http://test.joshbruce',
            // 'test'
        );
    }

    public static function rootContentRequest(): ServerRequestInterface
    {
        return new ServerRequest(
            method: 'GET',
            uri: '/',
            headers: [],
            serverParams: $_SERVER
        );
    }

    public static function rootContentResponse(): ResponseInterface
    {
        return RequestHandler::in(self::liveContentEnv())
            ->handle(self::rootContentRequest());
    }

    public static function thisSiteResponse(): ResponseInterface
    {
        return RequestHandler::in(self::liveContentEnv())
            ->handle(
                new ServerRequest(
                    method: 'GET',
                    uri: '/web-development/this-site',
                    headers: [],
                    serverParams: $_SERVER
                )
            );
    }
}
