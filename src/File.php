<?php

declare(strict_types=1);

namespace JoshBruce\Site;

use DateTime;
use DirectoryIterator;

use Symfony\Component\Yaml\Yaml;

use JoshBruce\Site\FileSystemInterface;
use JoshBruce\Site\ServerGlobals;

use JoshBruce\Site\Content\Mimetype;
use JoshBruce\Site\Content\Markdown;

class File
{
    private string $contentFileName = '/content.md';

    private string $contents = '';

    private Mimetype $mimetype;

    /**
     * @var array<string, mixed>
     */
    private array $frontMatter = [];

    public static function at(string $localPath, FileSystemInterface $in): File
    {
        return new File($localPath, $in);
    }

    private function __construct(
        private string $localPath,
        private FileSystemInterface $fileSystem
    ) {
    }

    public function fileSystem(): FileSystemInterface
    {
        return $this->fileSystem;
    }

    public function isNotXml(): bool
    {
        return $this->mimetype()->isNotXml();
    }

    /**
     * @todo: verify can be deprecated
     */
    public function isMarkdown(): bool
    {
        return str_ends_with($this->fileName(), '.md');
    }

    public function found(): bool
    {
        return file_exists($this->path()) and is_file($this->path());
    }

    public function isNotFound(): bool
    {
        return ! $this->found();
    }

    public function created(string $format = ''): string|int|false
    {
        return self::dateField('created', $format);
    }

    public function updated(string $format = ''): string|int|false
    {
        return self::dateField('updated', $format);
    }

    public function moved(string $format = ''): string|int|false
    {
        return self::dateField('moved', $format);
    }

    public function dateField(
        string $key,
        string $format = ''
    ): string|int|false {
        if ($this->frontMatterHasMember($key)) {
            $date = $this->frontMatter[$key];
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

    public function template(): string
    {
        if ($this->frontMatterHasMember('template')) {
            $frontMatter = $this->frontMatter();
            $template = $frontMatter['template'];
            if (is_string($template)) {
                return $template;
            }
        }
        return '';
    }

    public function description(int $length = 200): string
    {
        $description = '';
        if ($this->frontMatterHasMember('description')) {
            $frontMatter = $this->frontMatter();
            $desc = $frontMatter['description'];
            if (is_string($desc)) {
                $description = $desc;
            }

        } else {
            $body = $this->contents();
            $description = preg_filter(
                ["/#(.*)\n/", "/{!!(.*)!!}/"],
                ['', ''],
                $body
            );
            if (is_string($description)) {
                $parts = explode("\n", $description);
                $parts = array_filter($parts);
                $description = implode(' ', $parts);

            } else {
                // TODO: Doesn't guarantee meta description content.
                //       Log??
                $description = $body;

            }
        }

        $sentences = explode('. ', $description);

        $newLength = 0;
        $s = [];
        foreach ($sentences as $sentence) {
            $newLength += strlen($sentence);
            if ($newLength > $length) {
                break;
            }
            $s[] = strip_tags(
                Markdown::markdownConverter()->convert($sentence)
            );
            // $s[] = $sentence;
        }

        $description = implode('. ', $s);
        if (! str_ends_with($description, '.')) {
            $description .= '.';
        }
        return htmlspecialchars($description);
    }

    public function original(): string
    {
        if ($this->frontMatterHasMember('original')) {
            $frontMatter = $this->frontMatter();

            return strval($frontMatter['original']);
        }
        return '';
    }

    /**
     * @return array<int, int[]>
     */
    public function data(): array
    {
        if ($this->frontMatterHasMember('data')) {
            $frontMatter = $this->frontMatter();
            $data = $frontMatter['data'];
            if (is_array($data)) {
                return $data;
            }
        }
        return [];
    }

    public function frontMatterHasMember(string $member): bool
    {
        return array_key_exists($member, $this->frontMatter());
    }

    /**
     * @return array<string, mixed>
     */
    public function frontMatter(): array
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

    /**
     * @todo: move to trait
     */
    public function path(bool $full = true): string
    {
        if ($full) {
            return $this->localPath;
        }
        // TODO: test and verify used - returning empty string not an option.
        return str_replace(
            $this->fileSystem()->publicRoot(),
            '',
            $this->localPath
        );
    }

    public function canonicalUrl(): string
    {
        return str_replace(
            $this->contentFileName,
            '',
            ServerGlobals::init()->appUrl() . $this->path(false)
        );
    }

    public function filename(): string
    {
        $path = $this->path();
        $parts = explode('/', $path);
        return array_pop($parts);
    }

    public function mimetype(): Mimetype
    {
        if (! isset($this->mimetype)) {
            $this->mimetype = Mimetype::for($this->path());
        }
        return $this->mimetype;
    }

    public function title(): string
    {
        if (array_key_exists('title', $this->frontMatter())) {
            $frontMatter = $this->frontMatter();
            $title = $frontMatter['title'];
            if (is_string($title)) {
                return $title;
            }
        }
        return '';
    }

    public function pageTitle(): string
    {
        $titles   = [];
        $titles[] = $this->title();

        if (! str_contains($this->path(false), '/error-')) {
            $file = clone $this;
            while ($file->canGoUp()) {
                $file = $file->up();
                $titles[] = $file->title();
            }
        }

        $titles = array_filter($titles);
        return implode(' | ', $titles);
    }

    public function contents(): string
    {
        if (strlen($this->contents) === 0) {
            $contents = file_get_contents($this->path());
            if ($contents === false) {
                return '';
            }
            $this->frontMatter();
            // $this->contents = $contents;
        }
        return $this->contents;
    }

    private function up(): File
    {
        $parts = explode('/', $this->localPath);
        $parts = array_slice($parts, 0, -2); // remove file name and one folder.
        $localPath = implode('/', $parts);
        return File::at(
            $localPath . $this->contentFileName,
            $this->fileSystem()
        );
    }

    private function canGoUp(): bool
    {
        return $this->path(false) !== $this->contentFileName;
    }

    /**
     * @return File[]
     */
    public function children(string $filesNamed): array
    {
        $base = str_replace($this->contentFileName, '', $this->path());

        $files = [];
        foreach (new DirectoryIterator($base) as $folder) {
            if ($folder->isFile() or $folder->isDot()) {
                continue;
            }

            $fullPathToFolder = $folder->getPathname();
            $parts            = explode('/', $fullPathToFolder);
            $folderName       = array_pop($parts);

            $files[$folderName] = File::at(
                $fullPathToFolder . '/' . $filesNamed,
                $this->fileSystem()
            );
        }
        return $files;
    }
}
