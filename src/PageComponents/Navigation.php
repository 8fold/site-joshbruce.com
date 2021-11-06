<?php

declare(strict_types=1);

namespace JoshBruce\Site\PageComponents;

use Stringable;

use Eightfold\XMLBuilder\Contracts\Buildable;
use Eightfold\HTMLBuilder\Element as HtmlElement;

use JoshBruce\Site\FileSystem;
use JoshBruce\Site\Content\Markdown;

class Navigation implements Buildable, Stringable
{
    public static function create(string $fileName): Navigation
    {
        return new Navigation($fileName);
    }

    public function __construct(private string $fileName)
    {
    }

    private function listItem(string $for): HtmlElement
    {
        return HtmlElement::li(
            $this->anchor(for: $for)
        );
    }

    private function anchor(string $for): HtmlElement
    {
        list($href, $text) = explode(' ', $for, 2);
        return HtmlElement::a($text)->props('href ' . $href);
    }

    /**
     * @return array<string|array<string>>
     */
    private function navigation(): array
    {
        $file = FileSystem::init()->navigation($this->fileName);
            // die(var_dump($file));
        // $file = FileSystem::init($this->contentRoot)->navigation('main.md');
        // $file = $this->file->with(folderPath: '/navigation', fileName: 'main.md');
        return Markdown::init(file: $file)->frontMatter()->navigation();
    }

    public function build(): string
    {
        $li = [];
        $nav = $this->navigation();
        foreach ($nav as $item) {
            // TODO: Not sure this constitutes an elegant solution, but I can't
            //       seem to find another way. Use backslash for commas.
            $item = str_replace('\\', ',', $item);
            if (is_string($item)) {
                $li[] = $this->listItem(for: $item);

            } elseif (is_array($item)) {
                $l = '';
                $s = [];
                for ($i = 0; $i < count($item); $i++) {
                    if ($i === 0) {
                        $l = $this->anchor($item[$i]);

                    } else {
                        $s[] = $this->listItem($item[$i]);

                    }
                }

                $li[] = HtmlElement::li($l, HtmlElement::ul(...$s));
            }
        }
        return HtmlElement::nav(
            HtmlElement::ul(...$li)
        )->props('id main-nav')->build();
    }

    public function __toString(): string
    {
        return $this->build();
    }
}
