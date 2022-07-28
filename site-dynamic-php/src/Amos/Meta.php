<?php
declare(strict_types=1);

namespace Eightfold\Amos;

use StdClass;

class Meta
{
    private StdClass $decodedJson;

    public static function init(string $json): self
    {
        return new self($json);
    }

    final private function __construct(private string $json)
    {
    }

    public function valueExists(string $for): bool
    {
        return property_exists($this->decodedJson(), $for);
    }

    public function value(string $for): string
    {
        if ($this->valueExists($for)) {
            return $this->decodedJson()->{$for};
        }
    }

    private function decodedJson(): StdClass
    {
        if (isset($this->decodedJson) === false) {
            $this->decodedJson = json_decode($this->json(), false);
        }
        return $this->decodedJson;
    }

    private function json(): string
    {
        return $this->json;
    }
}
