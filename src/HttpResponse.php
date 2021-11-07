<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Psr\Http\Message\ResponseInterface;

use Nyholm\Psr7\Factory\Psr17Factory as PsrFactory;
use Nyholm\Psr7\Response as PsrResponse;

use JoshBruce\Site\HttpRequest;

class HttpResponse
{
    private PsrResponse $psrResponse;

    public static function from(HttpRequest $request): HttpResponse
    {
        return self::init($request);
    }

    public static function init(HttpRequest $with): HttpResponse
    {
        return new HttpResponse($with);
    }

    public function __construct(private $request)
    {
    }

    public function statusCode(): int
    {
        if ($this->request->isMissingRequiredValues()) {
            return 500;

        } elseif ($this->request->isUnsupportedMethod()) {
            return 405;

        } elseif ($this->request->isNotFound()) {
            return 404;

        }
        return 200;
    }

    public function body(): string
    {
        return (string) $this->psrResponse()->getBody();
    }

    public function headers(): array
    {
        return $this->psrResponse()->getHeaders();
    }

    public function psrResponse(): ResponseInterface
    {
        if (! isset($this->psrResponse)) {
            $psr17Factory = new PsrFactory();
            $this->psrResponse = $psr17Factory->createResponse(
                $this->statusCode()
            )->withBody(
                $psr17Factory->createStream('Hello, World!')
            );
        }
        return $this->psrResponse;
    }
}
