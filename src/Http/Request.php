<?php

declare(strict_types=1);

namespace JoshBruce\Site\Http;

use JoshBruce\Site\Http\Uri;

class Request
{
    public static function createFromServerGlobal(): Request
    {
        $uri = Uri::createFromServerGlobal();
        $method = $_SERVER['REQUEST_METHOD'];
        return Request::create($method, $uri);
    }

    public static function create(string $method, Uri $uri): Request
    {
        return new Request($method, $uri);
    }

    public function __construct(private string $method, private Uri $uri)
    {}

    public function method(): string
    {
        return $this->method;
    }

    public function uri(): Uri
    {
        return $this->uri;
    }
}
