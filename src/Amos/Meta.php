<?php
declare(strict_types=1);

namespace Eightfold\Amos;

use StdClass;

class Meta
{
    private StdClass|false $decodedJson = false;

    public static function init(string|false $json, string $path): self
    {
        return new self($json, $path);
    }

    final private function __construct(
        private string|false $json,
        private string $path
    ) {
    }

    public function path(): string
    {
        return $this->path;
    }

    public function valueExists(string $for): bool
    {
        if ($this->decodedJson() !== false) {
            return property_exists($this->decodedJson(), $for);
        }
        return false;
    }

    public function value(string $for): string
    {
        if ($this->valueExists($for)) {
            return $this->decodedJson()->{$for};
        }
        return '';
    }

    private function decodedJson(): StdClass|false
    {
        if ($this->decodedJson === false) {
            $decoded = json_decode($this->json());
            if ($decoded === null) {
                $this->decodedJson = false;

            } else {
                $this->decodedJson = $decoded;

            }
        }
        return $this->decodedJson;
    }

    private function json(): string
    {
        if ($this->json === false) {
            return '';
        }
        return $this->json;
    }
}
