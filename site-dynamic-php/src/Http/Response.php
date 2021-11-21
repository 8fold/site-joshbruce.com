<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Response as PsrResponse;

use JoshBruce\SiteDynamic\FileSystem\Finder;

class Response implements ResponseInterface
{
    private PsrResponse $response;

    private const ENV_REQUIRED = [
        'APP_ENV',
        'APP_URL'
    ];

    private const SUPPORTED_METHODS = [
      'GET'
    ];

    public static function from(RequestInterface $request): ResponseInterface
    {
        return new Response($request);
    }

    final private function __construct(private RequestInterface $request)
    {
    }

    private function request(): RequestInterface
    {
        return $this->request;
    }

    private function finder(): Finder
    {
        return $this->request()->finder();
    }

    private function psrResponse(): PsrResponse
    {
        if (! isset($this->response)) {
            $this->response = new PsrResponse(
                status: $this->statusCode(),
                headers: $this->headers(),
                body: $this->body(),
                reason: null
            );
        }
        return $this->response;
    }

    private function statusCode(): int
    {
        if ($this->envIsMissingRequiredKey()) {
            return 500;

        } elseif ($this->isUnsupportedMethod()) {
            return 405;

        }

        $file = $this->finder()->publicFileForRequest($this->request());
        if ($file->isNotFound()) {
            return 404;

        } elseif ($redirect = $file->redirect()) {
            // TODO: create HttpRedirect??
            // @phpstan-ignore-next-line
            $code = $redirect->code;
            return ($code >= 300 and $code <= 399) ? $code : 500;

        }
//         if ($this->envIsMissingRequiredKey()) {
//             return 500;
//
//         } elseif ($this->isUnsupportedMethod()) {
//             return 405;
//
//         } elseif ($this->isNotFound()) {
//             die('could be a redirect');
//             return 404;
//
//         } elseif (
//             $redirect = File::at(
//                 $this->localPath(),
//                 $this->fileSystem()
//             )->redirect()
//         ) {
//
//         }
        return 200;
    }

    private function headers(): array
    {
        return [];
    }

    /**
     * @todo User StreamInterface exclusively
     */
    private function body(): string|StreamInterface
    {
        return 'Hello, World!';
    }

    private function envIsMissingRequiredKey(): bool
    {
        return ! $this->envHasRequiredKeys();
    }

    private function envHasRequiredKeys():bool
    {
        foreach (self::ENV_REQUIRED as $key) {
            if (! array_key_exists($key, $_SERVER)) {
                return false;
            }
        }
        return true;
    }

    private function isUnsupportedMethod(): bool
    {
        return ! $this->isSupportedMethod();
    }

    private function isSupportedMethod(): bool
    {
        $requestMethod = strtoupper($this->request()->getMethod());
        return in_array($requestMethod, self::SUPPORTED_METHODS);
    }

    /**
     * The following methods aren't used directly,
     * they ensure compliance with the Message contract.
     */
    public function getStatusCode(): int
    {
        return $this->psrResponse()->getStatusCode();
    }

    public function getReasonPhrase(): string
    {
        return $this->psrResponse()->getReasonPhrase();
    }

    public function getHeaders(): array
    {
        return $this->psrResponse()->getHeaders();
    }

    public function getBody(): StreamInterface
    {
        return $this->psrResponse()->getBody();
    }

    public function getProtocolVersion(): string
    {
        return $this->request()->getProtocolVersion();
    }

    public function getHeader($header): array
    {
        return $this->psrResponse()->getHeader($header);
    }

    public function hasHeader($header): bool
    {
        return $this->psrResponse()->hasHeader($header);
    }

    public function getHeaderLine($header): string
    {
        return $this->psrResponse()->getHeaderLine($header);
    }

    /**
     * We want to minimize mutation of state, therefore,
     * these methods only exist to ensure contract compliance.
     */
    public function withStatus($code, $reasonPhrase = ''): self
    {
        $this->psrResponse()->withStatus($code, $reasonPhrase);
        return $this;
    }

    public function withProtocolVersion($version): self
    {
        $this->psrResponse()->withProtocolVersion($version);
        return $this;
    }

    public function withHeader($header, $value): self
    {
        $this->psrResponse()->withHeader($header, $value);
        return $this;
    }

    public function withAddedHeader($header, $value): self
    {
        $this->psrResponse()->withAddedHeader($header, $value);
        return $this;
    }

    public function withoutHeader($header): self
    {
        $this->psrResponse()->withoutHeader($header);
        return $this;
    }

    public function withBody(StreamInterface $body): self
    {
        $this->psrResponse()->withBody($body);
        return $this;
    }
}
