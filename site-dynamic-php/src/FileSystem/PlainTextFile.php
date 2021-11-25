<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

use JoshBruce\SiteDynamic\FileSystem\FileInterface;

use Symfony\Component\Yaml\Yaml;

use JoshBruce\SiteDynamic\FileSystem\FileTrait;

use JoshBruce\SiteDynamic\Documents\HtmlDefault;

class PlainTextFile implements FileInterface
{
    use FileTrait;

	private const FRONT_MATTER_DELIMITER = '---';

    private string $rawContent = '';

    private array $frontMatter = [];

    private string $content = '';

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
            if (strlen($format) === 0 and is_int($date)) {
                return $date;
            }

            $date = DateTime::createFromFormat('Ymd', strval($date));
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
        if (strlen($this->rawContent) === 0) {
            $this->rawContent = file_get_contents($this->localPath);
        }
        return $this->rawContent;
    }
}
