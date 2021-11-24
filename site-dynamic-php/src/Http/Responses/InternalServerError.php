<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http\Responses;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Stream;

use JoshBruce\SiteDynamic\Environment;

class InternalServerError
{
    public static function respondTo(
        Environment $environment,
        RequestInterface $request
    ): InternalServerError {
        return new InternalServerError($environment, $request);
    }

    final private function __construct(
        private Environment $environment,
        private RequestInterface $request
    ) {
    }

    public function statusCode(): int
    {
        return 500;
    }

    public function headers(): array
    {
        return [];
    }

    public function stream(): StreamInterface
    {
        // @todo: Add to list of required content
        $path    = $this->environment->publicRoot() . '/error-500.html';
        $content = file_get_contents($path);
        return Stream::create($content);
    }
}
