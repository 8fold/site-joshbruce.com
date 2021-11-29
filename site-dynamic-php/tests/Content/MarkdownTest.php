<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests;

use JoshBruce\SiteDynamic\Tests\LiveContentTestCase;

use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\Environment;

final class MarkdownTest extends LiveContentTestCase
{
    /**
     * @test
     *
     * @group markdown
     * @group live-content
     */
    public function there_can_be_only_one(): void
    {
        $this->assertSame(
            Markdown::markdownConverter(),
            Markdown::markdownConverter()
        );
    }

    /**
     * @test
     *
     * @group markdown
     * @group live-content
     */
    public function can_render_date_block_partial(): void
    {
        $file = self::rootContentFile();

        $start = hrtime(true);

        $markdown = Markdown::processPartials(
            <<<md
            {!! dateblock !!}
            md,
            $file,
            Environment::CONTENT_FILENAME
        ) . "\n";

        $end = hrtime(true);

        $this->assertSame(
            file_get_contents(__DIR__ . '/partial-output-date-block.html'),
            $markdown
        );

        $time = $end - $start;
        $ms   = $time/1e+6;

        // TODO: Wonder if we could make this smaller
        $this->assertLessThan(16, $ms);
    }
}
