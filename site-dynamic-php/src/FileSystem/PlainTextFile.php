<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

use JoshBruce\SiteDynamic\FileSystem\FileInterface;

use DateTime;

use Symfony\Component\Yaml\Yaml;

use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\Documents\HtmlDefault;

use JoshBruce\SiteDynamic\FileSystem\FileTrait;

class PlainTextFile implements FileInterface
{
    use FileTrait;

	private const FRONT_MATTER_DELIMITER = '---';

    private string $rawContent = '';

    private array $frontMatter = [];

    private string $content = '';

    private array $titleParts = [];

    public function hasMetadata(string $key): bool
    {
        $frontMatter = $this->frontMatter();
        return array_key_exists($key, $frontMatter);
    }

    public function template(): string
    {
        $frontMatter = $this->frontMatter();
        if (array_key_exists('template', $frontMatter)) {
            return $frontMatter['template'];
        }
        return '';
    }

    public function title(): string
    {
        $frontMatter = $this->frontMatter();
        if (array_key_exists('title', $frontMatter)) {
            $title = Markdown::markdownConverter()
                ->convert($frontMatter['title']);
            return strip_tags($title);
        }
        return '';
    }

    public function pageTitle(): string
    {
        return implode(' | ', $this->titleParts());
    }

    public function socialTitle(): string
    {
        $titles = $this->titleParts();

        $t = [];
        $t[] = array_shift($titles);
        if (count($titles) > 0) {
            $t[] = array_pop($titles);
        }
        return implode(' | ', $t);
    }

    private function titleParts(): array
    {
        if (count($this->titleParts) === 0) {
            $path = $this->path(omitFilename: true);

            $titles = [];
            $titles[] = $this->title();
            while (str_contains($path, $this->root)) {
                $parts = explode('/', $path);
                $parts = array_slice($parts, 0, -1);
                $path  = implode('/', $parts);

                if (str_contains($path, $this->root))
                {
                    $titles[] = PlainTextFile::at($path . '/content.md', $this->root)
                        ->title();
                }
            }

            $this->titleParts = $titles;

        }

        return $this->titleParts;
    }

    public function created(string $format = ''): string|int|false
    {
        return $this->dateField('created', $format);
    }

    public function moved(string $format = ''): string|int|false
    {
        return $this->dateField('moved', $format);
    }

    public function updated(string $format = ''): string|int|false
    {
        return $this->dateField('updated', $format);
    }

    public function redirect(): string
    {
        $frontMatter = $this->frontMatter();
        if (array_key_exists('redirect', $frontMatter)) {
            return $frontMatter['redirect'];
        }
        return '';
    }

    public function original(): string
    {
        $frontMatter = $this->frontMatter();
        if (array_key_exists('original', $frontMatter)) {
            return $frontMatter['original'];
        }
        return '';
    }

    public function frontMatter(): array
    {
        if (count($this->frontMatter) === 0) {
            $this->processRawContent();

        }

        return $this->frontMatter;
    }

    public function content(): string
    {
        if (strlen($this->content) === 0) {
            $this->processRawContent();

        }

        return $this->content;
    }

    /**
     * @return array<int, int[]>
     */
    public function data(): array
    {
        $frontMatter = $this->frontMatter();
        if (
            array_key_exists('data', $frontMatter) and
            $data = $frontMatter['data'] and
            is_array($data)
        ) {
            return $data;

        }
        return [];
    }

    private function dateField(
        string $key,
        string $format = ''
    ): string|int|false {
        $frontMatter = $this->frontMatter();
        if (array_key_exists($key, $frontMatter)) {
            $date = $frontMatter[$key];

            if (strlen($format) === 0) {
                return intval($date);

            }

            $date = DateTime::createFromFormat(
                'Ymd',
                strval($date)
            );

            if ($date) {
                return $date->format($format);
            }
        }
        return false;
    }

    private function processRawContent(): void
    {
        $parts = explode(self::FRONT_MATTER_DELIMITER, $this->rawContent());
		if (
			count($parts) === 3 and
			$possible = Yaml::parse($parts[1]) and
			is_array($possible)
		) {
			$this->frontMatter = $possible;
            $this->content = $parts[2];

		} else {
            $this->content = $parts[0];

        }
    }

    private function rawContent(): string
    {
        return file_get_contents($this->path());
    }
}
