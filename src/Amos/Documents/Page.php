<?php
declare(strict_types=1);

namespace Eightfold\Amos\Documents;

use Stringable;

use Eightfold\XMLBuilder\Document;
use Eightfold\XMLBuilder\Element;

use Eightfold\Amos\Site;

class Page implements Stringable
{
    public static function create(Site $site): self
    {
        return new self($site);
    }

    final private function __construct(private Site $site)
    {
    }

    private function site(): Site
    {
        return $this->site;
    }

    public function __toString(): string
    {
        $site = $this->site();
        return '';
    }
}
