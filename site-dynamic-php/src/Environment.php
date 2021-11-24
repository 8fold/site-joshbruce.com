<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic;

use SplFileInfo;

use Dotenv\Dotenv;

class Environment
{
    private const ENV_REQUIRED = [
        // dev|test|production
        'APP_ENV',
        // HTTP(S) URI root.
        'APP_URL',
        // Comma delimited list of supported request methods.
        'APP_METHODS',
        // Path to folder containing containing, relative to project root.
        'CONTENT_PATH',
        // Default name of file containing web content.
        'CONTENT_FILENAME'
    ];

    private const PUBLIC_FOLDERNAME = 'public';

    private $hasRequiredVariables = true;

    public static function with(string $pathToEnv): Environment
    {
        return new Environment($pathToEnv);
    }

    final private function __construct(private string $path)
    {
        // Inject .env content into server globals
        Dotenv::createImmutable($path)->load();
        $this->hasRequiredVariables();
    }

    public function supportedMethods(): array
    {
        $list = $_SERVER['APP_METHODS'];
        return explode(',', $list);
    }

    public function isMissingVariables():bool
    {
        return ! $this->hasRequiredVariables();
    }

    private function hasRequiredVariables(): bool
    {
        if ($this->hasRequiredVariables) {
            foreach (self::ENV_REQUIRED as $required) {
                if (! array_key_exists($required, $_SERVER)) {
                    $this->hasRequiredVariables = false;
                    break;
                }
            }
        }
        return $this->hasRequiredVariables;
    }

    public function isMissingFolders(): bool
    {
        return ! $this->hasRequiredFolders();
    }

    private function hasRequiredFolders(): bool
    {
        return file_exists($this->publicRoot()) and
            is_dir($this->publicRoot());
    }

    private function projectRoot(): string
    {
        $rPath = __DIR__ . '/../../';
        return (new SplFileInfo($rPath))->getRealPath();
    }

    public function contentRoot(): string
    {
        if ($this->hasRequiredVariables()) {
            return $this->projectRoot() . $_SERVER['CONTENT_PATH'];
        }
        return $this->projectRoot();
    }

    public function publicRoot(): string
    {
        return $this->contentRoot() . '/' . self::PUBLIC_FOLDERNAME;
    }
}
