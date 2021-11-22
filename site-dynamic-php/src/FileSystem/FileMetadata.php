<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

use SplFileInfo;

use Symfony\Component\Yaml\Yaml;

use JoshBruce\Site\Content\Markdown;
use JoshBruce\SiteDynamic\FileSystem\FileMimetype;

class FileMetadata
{
	private SplFileInfo $fileInfo;

	private array $frontMatter = [];

	public const FRONT_MATTER_DELIMETER = '---';

	public static function for(string $localPath): static
	{
		return new static($localPath);
	}

	final private function __construct(private string $localPath)
	{
	}

	/**
	 * Same as `getBasename` without a suffix
	 */
    public function filename(bool $withExtension = true): string
    {
        if ($withExtension) {
            return $this->fileInfo()->getFilename();
        }
		return $this->basename('.' . $this->extension());
    }

	public function extension(): string
	{
		return $this->fileInfo()->getExtension();
	}

	public function path(bool $omitFilename = false): string
	{
		if ($omitFilename) {
			return $this->fileInfo()->getPath();
		}
		return $this->realPath();
	}

	public function mimetype(): FileMimetype
	{
		$raw = mime_content_type($this->path());
		return FileMimetype::with($raw, $this->extension());
	}

	public function mightHaveFrontMatter(): bool
	{
		return $this->mimetype()->raw() === 'text/plain';
	}

	public function frontMatter(): array
	{
        if (
			count($this->frontMatter) === 0 and
			$this->mightHaveFrontMatter()
		) {
			// TODO: This is an argument for putting all metadata into
			//       file. Or, making File a factory-like object that
			//       might instantiate PlainTextFile versus some more
			//       generic file type; ex. ImageFile.
			$contents = file_get_contents($this->path());
			$parts    = explode(self::FRONT_MATTER_DELIMETER, $contents);

			if (
				count($parts) === 3 and
				$possible = Yaml::parse($parts[1]) and
				is_array($possible)
			) {
				$this->frontMatter = $possible;

			}
		}
		return $this->frontMatter;
	}

	private function fileInfo(): SplFileInfo
	{
		if (! isset($this->fileInfo)) {
			$this->fileInfo = new SplFileInfo($this->localPath);
		}
		return $this->fileInfo;
	}

	private function basename(string $suffixToOmit = ''): string
	{
		return $this->fileInfo()->getBasename($suffixToOmit);
	}

	private function pathname(): string
	{
		return this->realPath();
	}

	private function realPath(): string
	{
		$p = $this->fileInfo()->getRealPath();
		if ($p) {
			return $p;
		}
		return '';
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
}
