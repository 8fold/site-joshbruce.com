<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Http;

use Stringable;

use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

use Nyholm\Psr7\Uri as PsrUri;

class Uri implements UriFactoryInterface, UriInterface, Stringable
{
    private PsrUri $uri;

    public static function create(string $uri = ''): UriInterface
    {
        return (new static())->createUri($uri);
    }

    public function createUri(string $uri = ''): UriInterface
    {
        // request doesn't pass in string for reasons unknown
        if (strlen($uri) > 0) {
            $this->uri = new PsrUri($uri);
            return $this;
        }

        // build from super globals by default
        $scheme = (array_key_exists('REQUEST_SCHEME', $_SERVER))
            ? $_SERVER['REQUEST_SCHEME']
            : 'http';

        if (! array_key_exists('SERVER_NAME', $_SERVER)) {
            $appUrl = $_SERVER['APP_URL'];
            $parsed = parse_url($appUrl);
            $_SERVER['SERVER_NAME'] = $parsed['host'];

        }

        $host = (array_key_exists('SERVER_PORT', $_SERVER))
            ? $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']
            : $_SERVER['SERVER_NAME'];

        if (! array_key_exists('REQUEST_URI', $_SERVER)) {
            $_SERVER['REQUEST_URI'] = '';

        }

        $path = $_SERVER['REQUEST_URI'];

        // no user ever
        // no query at this time
        // fragment doesn't get sent with request
        // user means no password

        $this->uri = new PsrUri($scheme . '://' . $host . $path);
        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->uri;
    }

    public function isFile(): bool
    {
        $path  = $this->getPath();
        $parts = explode('/', $path);
        $possibleFileName = array_pop($parts);
        if (str_contains($possibleFileName, '.')) {
            return true;
        }
        return false;
    }

    /**
     * UriInterface methods
     */
    public function getPath(): string
    {
        return $this->uri->getPath();
    }

    /**
     * The following methods aren't used directly,
     * this class ensures compliance with contracts and
     * is used as a decorator, proxy, or facade for PsrUri.
     * (At the moment I'm not what the nuanced differences are.)
     */
    public function getScheme(): string
    {
        return $this->uri->getScheme();
    }

    public function getAuthority(): string
    {
        return $this->uri->getAuthority();
    }

    public function getUserInfo(): string
    {
        return $this->uri->getUserInfo();
    }

    public function getHost(): string
    {
        return $this->uri->getHost();
    }

    public function getPort(): ?int
    {
        return $this->uri->getPort();
    }

    public function getQuery(): string
    {
        return $this->uri->getQuery();
    }

    public function getFragment(): string
    {
        return $this->uri->getFragment();
    }

    public function withScheme($scheme): self
    {
        // $this->uri = $this->uri->withScheme($scheme);
        return $this;
    }

    public function withUserInfo($user, $password = null): self
    {
        // $this->uri = $this->uri->withUserInfo($user, $password);
        return $this;
    }

    public function withHost($host): self
    {
        // $this->uri = $this->uri->withHost($host);
        return $this;
    }

    public function withPort($port): self
    {
        // $this->uri = $this->uri->withPort($port);
        return $this;
    }

    public function withPath($path): self
    {
        // $this->uri = $this->uri->withPath($path);
        return $this;
    }

    public function withQuery($query): self
    {
        // $this->uri = $this->uri->withQuery($query);
        return $this;
    }

    public function withFragment($fragment): self
    {
        // $this->uri = $this->uri->withFragment($fragment);
        return $this;
    }
}
