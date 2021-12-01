<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests\Content;

use JoshBruce\SiteDynamic\Tests\LiveContentTestCase;

use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

final class MarkdownTest extends LiveContentTestCase
{
    /**
     * @test
     *
     * @group markdown
     * @group live-content
     */
    public function there_can_be_only_one(): void // phpcs:ignore
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
    public function can_render_date_block_partial(): void // phpcs:ignore
    {
        $file = self::rootContentFile();

        $start = hrtime(true);

        $html = Markdown::processPartials(
            <<<md
            {!! dateblock !!}
            md,
            $file,
            self::liveContentEnv()
        ) . "\n";

        $end = hrtime(true);

        $this->assertSame(
            file_get_contents(__DIR__ . '/partial-output-date-block.html'),
            $html
        );

        $time = $end - $start;
        $ms   = $time / 1e+6;

        // TODO: Wonder if we could make this smaller
        $this->assertLessThan(25, $ms);
    }

    /**
     * @test
     *
     * @group markdown
     * @group live-content
     */
    public function can_render_code_blocks_properly(): void // phpcs:ignore
    {
//         $expected = file_get_contents(__DIR__ . '/code-block-output.html');
//         $markdown = file_get_contents(__DIR__ . '/code-block-input.md');
//
//         if (is_string($expected) and is_string($markdown)) {
//             $this->assertSame(
//                 $expected,
//                 Markdown::markdownConverter()->convert($markdown)
//             );
//
//         } else {
//             $this->assertIsString($expected);
//             $this->assertIsString($markdown);
//
//         }

        $expected = file_get_contents(__DIR__ . '/front-matter-code-block-output.html');
        $markdown = file_get_contents(__DIR__ . '/front-matter-code-block-input.md');

        if (is_string($expected) and is_string($markdown)) {
            $this->assertSame(
                $expected,
                Markdown::markdownConverter()->convert($markdown)
            );

        } else {
            $this->assertIsString($expected);
            $this->assertIsString($markdown);

        }

        $file = PlainTextFile::at(
            __DIR__ . '/front-matter-code-block-input.md',
            __DIR__
        );

        $content = $file->content();

        $body = Markdown::processPartials($content, $file, self::liveContentEnv());

        $this->assertSame(
            file_get_contents(__DIR__ . '/front-matter-code-block-output.html'),
            Markdown::markdownConverter()->convert($body)
        );
    }
}
