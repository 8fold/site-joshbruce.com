<?php

declare(strict_types=1);

namespace JoshBruce\Site\Content;

use DirectoryIterator;

use Eightfold\Markdown\Markdown as MarkdownConverter;

use JoshBruce\Site\FileSystem;

use JoshBruce\Site\PageComponents\Data;
use JoshBruce\Site\PageComponents\DateBlock;
use JoshBruce\Site\PageComponents\Heading;
use JoshBruce\Site\PageComponents\LogList;
use JoshBruce\Site\PageComponents\OriginalContentNotice;

use JoshBruce\Site\Content\FrontMatter;

class Markdown
{
    private string $markdown = '';

    /**
     * @var FrontMatter
     */
    private FrontMatter $frontMatter;

    public static function init(FileSystem $file): Markdown
    {
        return new Markdown($file);
    }

    public static function markdownConverter(): MarkdownConverter
    {
        return MarkdownConverter::create()
            ->minified() // can't be minified due to code blocks
            ->smartPunctuation()
            ->withConfig(['html_input' => 'allow'])
            ->abbreviations()
            ->externalLinks([
                'open_in_new_window' => true
            ])->headingPermalinks(
                [
                    'min_heading_level' => 2,
                    'symbol' => '＃'
                ],
            );
    }

    public function __construct(private FileSystem $file)
    {
    }

    public function convert(): string
    {
        // TODO: cache as property
        $body = self::markdownConverter()->getBody($this->markdown());
        $body = Data::create(frontMatter: $this->frontMatter()) .
            "\n\n" . $body;

        $originalLink = '';
        $copy = $this->file->with('/messages', 'original.md');
        if (
            $this->frontMatter()->hasMember('original') and
            $copy->found()
        ) {
            $copyContent = file_get_contents($copy->filePath());
            if (is_string($copyContent)) {
                $originalLink = OriginalContentNotice::create(
                    copyContent: $copyContent,
                    messagePath: $copy->filePath(),
                    originalLink: $this->frontMatter()->original()
                );
            }
        }

        $body = $originalLink . "\n\n" . $body;

        $body = DateBlock::create(frontMatter: $this->frontMatter()) .
            "\n\n" . $body;

        if ($this->file->isNotRoot()) {
            $body = Heading::create(frontMatter: $this->frontMatter()) .
                "\n\n" . $body;
        }

        $body = $body . "\n\n" . LogList::create(
            $this->frontMatter(),
            $this->file
        );

        return self::markdownConverter()->convert($body);
    }

    public function markdown(): string
    {
        if (strlen($this->markdown) === 0 and $this->file->found()) {
            $markdown = file_get_contents($this->file->filePath());

            if (is_bool($markdown)) {
                $markdown = '';
            }

            $this->markdown = $markdown;
        }
        return $this->markdown;
    }

    /**
     * @todo: test
     */
    public function frontMatter(): FrontMatter
    {
        if (! isset($this->frontMatter)) {
            $frontMatter = self::markdownConverter()
                ->getFrontMatter($this->markdown());
            $this->frontMatter = FrontMatter::init($frontMatter);
        }
        return $this->frontMatter;
    }

    public function hasMoved(): bool
    {
        return strlen($this->redirectPath()) > 0;
    }

    public function redirectPath(): string
    {
        return $this->frontMatter()->redirectPath();
    }
}
