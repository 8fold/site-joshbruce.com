<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use Nyholm\Psr7\Response as PsrResponse;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

trait ResponseCycleTrait
{
    public static function with(
        $file,
        Environment $environment,
        ServerRequestInterface $request
    ): InternalServerError {
        return new InternalServerError($file, $environment, $request);
    }

    final private function __construct(
        private PlainTextFile $file,
        private Environment $environment,
        private ServerRequestInterface $request
    ) {
    }

    public function respond(): ResponseInterface
    {
        return new PsrResponse(
            status: $this->statusCode(),
            headers: $this->headers(),
            body: $this->stream()
        );
    }
}
