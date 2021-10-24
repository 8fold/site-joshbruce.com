<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use JoshBruce\Site\Environment;
use JoshBruce\Site\Http\Response;
use JoshBruce\Site\Emitter;

class App
{
    public static function emitResponse(array $serverGlobals): void
    {
        $response = null;
        // Verify environment has minimal structure
        $env = Environment::init($_SERVER);
        if ($env->isNotVerified()) {
            $response = $env->response();

        } else {
            $response = App::init($env)->response();

        }
        Emitter::emit($response);
    }

    public static function init(Environment $environment)
    {
        return new App($environment);
    }

    final public function __construct(private Environment $environment)
    {
    }

    public function response(): Response
    {
        if ($this->contentExistsForRequest()) {
            return Response::create(
                200,
                headers: [
                    'Cache-Control' => ['max-age=600']
                ],
                body: <<<html
                    <!doctype html>
                    <html>
                        <head>
                            <title>Josh Bruce's personal site</title>
                            <style>
                                h1 {
                                    text-align: center;
                                }
                            </style>
                        </head>
                        <body>
                            <h1>The domain of Josh Bruce</h1>
                            <p>This content was successfully found.</p>
                        </body>
                    </html>
                    html,
                reason: 'Ok'
            );
        }
        return Response::create(
            404,
            headers: [
                'Cache-Control' => [
                    'no-cache',
                    'must-revalidate'
                ]
            ],
            body: <<<html
                <!doctype html>
                <html>
                    <head>
                        <title>Not found | Josh Bruce's personal site</title>
                        <style>
                            h1 {
                                text-align: center;
                            }
                        </style>
                    </head>
                    <body>
                        <h1>404: Not found</h1>
                        <p>We still haven't found what you're looking for.</p>
                    </body>
                </html>
                html,
            reason: 'Not found'
        );
    }

    private function environment(): Environment
    {
        return $this->environment;
    }

    private function requestFilePath(): string
    {
        $contentRoot     = $this->environment()->contentRoot();
        $requestParts    = explode('/', $contentRoot);
        $requestUriParts = explode('/', $this->environment()->requestUri());
        $parts           = array_merge($requestParts, $requestUriParts);
        $parts[]         = 'content.md';
        $parts           = array_filter($parts);

        return '/' . implode('/', $parts);
    }

    private function contentExistsForRequest(): bool
    {
        return file_exists($this->requestFilePath()) and
            is_file($this->requestFilePath());
    }
}
