<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Nyholm\Psr7\Factory\Psr17Factory as PsrFactory;
use Nyholm\Psr7\Response as PsrResponse;

use JoshBruce\Site\HttpResponse;

class HttpRequest
{
    public static function init(): HttpRequest
    {
        return new HttpRequest();
    }

    public function __construct()
    {
    }

    public function response(): HttpResponse
    {

    }
}
