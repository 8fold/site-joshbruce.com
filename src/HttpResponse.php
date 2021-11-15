<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Factory\Psr17Factory as PsrFactory;
use Nyholm\Psr7\Response as PsrResponse;
use Nyholm\Psr7\Stream as PsrStream;

use JoshBruce\Site\HttpRequest;

use JoshBruce\Site\Documents\Sitemap;
use JoshBruce\Site\Documents\HtmlDefault;

class HttpResponse
{
    private ResponseInterface $psrResponse;

    public static function from(HttpRequest $request): HttpResponse
    {
        return new HttpResponse($request);
    }

    private function __construct(private HttpRequest $request)
    {
    }

    public function statusCode(): int
    {
        return $this->request()->statusCode();
    }

    /**
     * @return array<string, int|string|string[]>
     */
    public function headers(): array
    {
        $headers = [];
        if ($this->statusCode() === 200) {
            $headers['Content-Type'] = $this->request()->localFile()
                ->mimeType()->type();

        } elseif ($this->statusCode() === 404) {
            $headers['Content-Type'] = 'text/html';

        }
        return $headers;
    }

    public function body(): string
    {
        $localFile = $this->request()->localFile();
        if ($localFile->isNotXml()) {
            return $localFile->path();
        }

        $template  = $localFile->template();
        if (strlen($template) === 0) {
            $template = 'default';
        }

        return match ($template) {
            'sitemap' => Sitemap::create($localFile, $this->request()),
            default => HtmlDefault::create($localFile, $this->request())
        };
    }

    public function psrResponse(): ResponseInterface
    {
        if (! isset($this->psrResponse)) {
            $psr17Factory = new PsrFactory();
            $body         = $this->body();
            $stream       = $psr17Factory->createStream($body);
            if (
                $this->request()->isFile() and
                $this->request()->isNotSitemap()
            ) {
                $stream = $psr17Factory->createStreamFromFile($body);
            }

            $this->psrResponse = new PsrResponse(
                $this->statusCode(),
                $this->headers(),
                $stream
            );
        }
        return $this->psrResponse;
    }

    private function request(): HttpRequest
    {
        return $this->request;
    }
}
