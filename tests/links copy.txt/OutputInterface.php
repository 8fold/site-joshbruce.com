<?php

namespace JoshBruce\Site\Tests\StaticGenerator;

use Symfony\Component\Console\Output\Output;

class OutputInterface extends Output
{
    protected function doWrite(string $message, bool $newline): void
    {
        // do nothing
    }
}
