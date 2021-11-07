<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

use Psr\Http\Message\RequestInterface;

use Nyholm\Psr7\Factory\Psr17Factory as PsrFactory;
use Nyholm\Psr7\Response as PsrResponse;

use JoshBruce\Site\ServerGlobals;
use JoshBruce\Site\HttpResponse;

class HttpRequest
{
    private RequestInterface $psrRequest;

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

    public function isMissingRequiredValues(): bool
    {
        if ($this->serverGlobals()->isMissingAppEnv()) {
            return true;
        }

        if ($this->serverGlobals()->appEnvIsNot('production')) {
            // use Whoops! for error display
            $errorHandler = new Run();
            $errorHandler->pushHandler(new PrettyPageHandler());
            $errorHandler->register();
        }

        return false;
    }

    private function serverGlobals(): ServerGlobals
    {
        return ServerGlobals::init();
    }

    private function request(): RequestInterface
    {
        if (! isset($this->psrRequest)) {
            $psr17Factory = new Nyholm\Psr7\Factory\Psr17Factory();
            $creator      = new Nyholm\Psr7Server\ServerRequestCreator(
                $psr17Factory,
                $psr17Factory,
                $psr17Factory,
                $psr17Factory
            );

            $this->psrRequest = $creator->fromGlobals();
        }
        return $this->psrRequest;
    }
}
