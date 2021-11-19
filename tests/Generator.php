<?php

declare(strict_types=1);

namespace JoshBruce\Site\Tests;

use JoshBruce\Site\ServerGlobals;

class TestServerGlobals extends ServerGlobals
{
    public function unsetAppEnv(): TestServerGlobals
    {
        $this->globals = [];

        unset($_SERVER['APP_ENV']);
        return $this;
    }

    public function resetAppEnv(): void
    {
        $_SERVER['APP_ENV'] = 'test';
    }
}
