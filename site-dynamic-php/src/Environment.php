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
        // Path to folder containing public folder, relative to .env location.
        'ENV_TO_PUBLIC_ROOT',
        // Default name of file containing web content.
        'CONTENT_FILENAME'
    ];

    private bool $hasRequiredVariables = true;

    private const FILE_SEPARATOR = '/';

    private string $publicRoot = '';

    public static function with(string $pathToEnv): Environment
    {
        return new Environment($pathToEnv);
    }

    final private function __construct(private string $pathToEnv)
    {
        // Inject .env content into server globals
        Dotenv::createImmutable($pathToEnv)->load();
        $this->hasRequiredVariables();
    }

    /**
     * @return string[]
     */
    public function supportedMethods(): array
    {
        $list = $_SERVER['APP_METHODS'];
        return explode(',', $list);
    }

    public function isMissingVariables(): bool
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

    public function contentRoot(): string
    {
        $parts = explode(self::FILE_SEPARATOR, $this->publicRoot());
        $parts = array_slice($parts, 0, -1);
        return implode(self::FILE_SEPARATOR, $parts);
    }

    public function publicRoot(): string
    {
        if (strlen($this->publicRoot) === 0) {
            // Cached locally to improve performance.
            // Call count for index.php process was 8, now 1.
            $fileInfo = new SplFileInfo(
                $this->pathToEnv . $_SERVER['ENV_TO_PUBLIC_ROOT']
            );

            $realPath = $fileInfo->getRealPath();
            if (! $realPath) {
                $realPath = '';
            }

            $this->publicRoot = $realPath;
        }
        return $this->publicRoot;
    }
}
