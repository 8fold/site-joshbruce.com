<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

use SplFileInfo;

use Symfony\Component\Yaml\Yaml;

use JoshBruce\Site\Content\Markdown;

class FileMetadata
{
	private SplFileInfo $fileInfo;

	private array $frontMatter = [];

	public static function for(string $localPath): static
	{
		return new static($localPath);
	}

	final private function __construct(private string $localPath)
	{
	}

	private function fileInfo(): SplFileInfo
	{
		if (! isset($this->fileInfo)) {
			$this->fileInfo = new SplFileInfo($this->path());
		}
		return $this->fileInfo;
	}

    public function filename(): string
    {
		return $this->fileInfo()->getFilename();
        // $path = $this->localPath;
        // $parts = explode('/', $path);
        // return array_pop($parts);
    }

	private function extension(): string
	{
		return $this->fileInfo()->getExtension();
	}

    private function isNotHtml(): bool
    {
        return $this->extension() !== 'html' and $this->extension() !== 'md';
    }

    public function isNotXml(): bool
    {
        return $this->extension() !== 'xml' and $this->isNotHtml();
    }

	public function has(string $key): bool
	{
		$frontMatter = $this->frontMatter();
		return array_key_exists($key, $frontMatter);
	}

	public function title(): string
	{
		if ($this->has('title')) {
			$frontMatter = $this->frontMatter();
			return strip_tags(
				Markdown::markdownConverter()
					->convert($frontMatter['title'])
				);
		}
		return '';
	}

	private function path(): string
	{
		return $this->localPath;
	}

	private function frontMatter(): array
	{
        if (count($this->frontMatter) === 0) {
            if ($this->isNotXml()) {
                // return as early as possible
                return [];
            }

            $contents = file_get_contents($this->path());
            if (is_bool($contents)) {
                return [];
            }

            $parts = explode('---', $contents);

            if (count($parts) === 1) {
                $this->contents = $parts[0];
                $this->frontMatter = [];

            } else {
                $this->contents = $parts[2];
                $metadata = Yaml::parse($parts[1]);
                if (is_array($metadata)) {
                    $this->frontMatter = $metadata;
                }
            }
        }
        return $this->frontMatter;
	}
}
