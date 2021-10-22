<?php

declare(strict_types=1);

namespace JoshBruce\Site\Http;

use Stringable;

/**
 * This class is not meant to be a full implementation of as defined by PSR-7:
 * https://www.php-fig.org/psr/psr-7/ - section 3.5; rather, it's a site-specific
 * implementation of a public interface that may be used as a proxy of a PSR-7
 * implementation, if needed. (ex. We will not need to account for things like
 * user info in this implementation. Further, queries and fragments will not
 * be used to alter content on th pages, so, no need to account for them in this
 * API.)
 *
 * It uses the $_SERVER associative array, which is explicitly injected.
 */
class Uri implements Stringable
{
    public static function createFromServerGlobal(): Uri
    {
        return static::create($_SERVER);
    }

    public static function create(array $globalBasedValues): Uri
    {
        return new Uri($globalBasedValues);
    }

    public function __construct(
        private $globalBasedValues
    ) {
    }

    public function __toString(): string
    {
        return $this->full();
    }

    private function scheme(): string
    {
        return $this->globalBasedValues['REQUEST_SCHEME'];
    }

    private function host(): string
    {
        return $this->globalBasedValues['HTTP_HOST'];
    }

    private function port(): string
    {
        return $this->globalBasedValues['SERVER_PORT'];
    }

    private function path(): string
    {
        return $this->globalBasedValues['REQUEST_URI'];
    }

    private function full()
    {
        $b = $this->scheme() . '://' . $this->host();
        if (strlen($this->port()) > 0) {
            $b .= ':' . $this->port();
        }
        return $b . $this->path();
    }
}
