<?php

declare(strict_types=1);

class App
{
    private const ENV_REQUIRED = [
        'APP_ENV',
        'APP_URL'
    ];

    private const SUPPORTED_METHODS = [
      'GET'
    ];

    public function envIsMissingRequiredKey(): bool
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
}
