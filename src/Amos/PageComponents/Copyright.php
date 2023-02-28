<?php
declare(strict_types=1);

namespace Eightfold\Amos\PageComponents;

use Stringable;
// use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\HTMLBuilder\Element;

class Copyright implements Stringable // Buildable
{
    public static function create(
        string $holder,
        string $startYear = ''
    ): self {
        return new self($holder, $startYear);
    }

    final private function __construct(
        private string $holder,
        private string $startYear
    ) {
    }

    public function __toString(): string
    {
        $time = date('Y');
        if (strlen($this->startYear) > 0) {
            $time = $this->startYear . '–' . $time;
        }

        return (string) Element::p(
            'Copyright © ' . $time . ' ' . $this->holder . '. All rights reserved.'
        );
    }
}
