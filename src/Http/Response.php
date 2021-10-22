<?php

declare(strict_types=1);

namespace JoshBruce\Site\Http;

use Eightfold\Amos\Store;

use JoshBruce\Site\Http\Uri;
use JoshBruce\Site\Http\Request;

class Response
{
    public static function createFromServerGlobal(Store $store): Response
    {
        $uri = Uri::createFromServerGlobal();
        $method = $_SERVER['REQUEST_METHOD'];
        $request = Request::create($method, $uri);
        return Response::create($request, $store);
    }

    public static function create(
        Request $request,
        Store $store
    ): Response {
        return new Response($request, $store);
    }

    public function __construct(
        private Request $request,
        private Store $store
    ) {
    }

    public function request(): string
    {
        return $this->request;
    }

    public function store(): Store
    {
        return $this->store;
    }

    public function body(): string
    {
        return '';
    }
}
