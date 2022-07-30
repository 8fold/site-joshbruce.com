<?php
declare(strict_types=1);

namespace Eightfold\Amos;

use StdClass;

class Meta
{
    private StdClass|false $decodedJson = false;

    public static function init(string|false $json): self
    {
        return new self($json);
    }

    final private function __construct(private string|false $json)
    {
    }

    public function valueExists(string $for): bool
    {
        if ($this->decodedJson() !== false) {
            // is_a($this->decodedJson(), StdClass::class) === false) {
            // return false;
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
            $decoded = json_decode($this->json(), false);
            if ($decoded === null) {
                $this->decodedJson = false;
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
