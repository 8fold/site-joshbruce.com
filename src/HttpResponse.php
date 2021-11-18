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
use JoshBruce\Site\Documents\AtomFeed;
use JoshBruce\Site\Documents\HtmlDefault;
use JoshBruce\Site\Documents\FullNav;

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

        } elseif ($this->statusCode() > 300 and $this->statusCode() < 399) {
            if ($redirect = $this->request()->localFile()->redirect()) {
                // TODO: create HttpRedirect??
                // @phpstan-ignore-next-line
                $headers['Location'] = $redirect->destination;

            }
        }
        return $headers;
    }

    public function body(): string
    {
        $localFile = $this->request()->localFile();
        if ($localFile->isNotXml()) {
            return $localFile->path();
        }

        if ($this->statusCode() === 500) {
            return $localFile->contents();
        }

        $template  = $localFile->template();
        if (strlen($template) === 0) {
            $template = 'default';
        }

        $xml = match ($template) {
            'sitemap'   => Sitemap::create($localFile),
            'full-nav'  => FullNav::create($localFile),
            'atom-feed' => AtomFeed::create($localFile),
            default     => HtmlDefault::create($localFile)
        };

        $xml = str_replace(
            ['href="/', 'src="/'],
            [
                'href="' . $this->request()->serverGlobals()->appUrl() . '/',
                'src="' . $this->request()->serverGlobals()->appUrl() . '/',
            ],
            $xml
        );

        return $xml;
    }

    public function psrResponse(): ResponseInterface
    {
        if (! isset($this->psrResponse)) {
            $psr17Factory = new PsrFactory();
            $body         = $this->body();
            $stream       = $psr17Factory->createStream($body);
            if (
                $this->request()->isFile() and
                $this->request()->localFile()->isNotXml()
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
