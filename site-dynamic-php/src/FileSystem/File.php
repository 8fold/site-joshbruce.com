<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

use SplFileInfo;
use DateTime;
use DirectoryIterator;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

use Nyholm\Psr7\Factory\Psr17Factory as PsrFactory;

// use Symfony\Component\Yaml\Yaml;

use JoshBruce\SiteDynamic\FileSystem\FileMetadata;
use JoshBruce\SiteDynamic\FileSystem\FileMimetype;
use JoshBruce\SiteDynamic\Content\Markdown;

// use JoshBruce\Site\FileSystemInterface;
// use JoshBruce\Site\ServerGlobals;
// use JoshBruce\Site\Content\Mimetype;

class File
{
    private FileMetadata $metadata;

//     private string $contentFileName = '/content.md';
//
    private string $contents = '';
//
//     private Mimetype $mimetype;

    /**
     * @var array<string, mixed>
     */
    // private array $frontMatter = [];

    public static function at(string $localPath, string $root): File
    {
        return new File($localPath, $root);
    }

    private function __construct(
        private string $localPath,
        private string $root
    ) {
    }

    public function metadata(): FileMetadata
    {
        if (! isset($this->metadata)) {
            $this->metadata = FileMetadata::for($this->localPath);
        }
        return $this->metadata;
    }

    public function mimetype(): FileMimetype
    {
        return $this->metadata()->mimetype();
    }

    public function extension(): string
    {
        return $this->metadata()->extension();
    }

    public function filename(bool $withExtension = true): string
    {
        return $this->metadata()->filename($withExtension);
    }

    public function path(bool $omitFilename = false): string
    {
        return $this->metadata()->path($omitFilename);
    }

    public function statusCode(): int
    {
        return 200;
    }

    public function headers(): array
    {
        return [];
    }

    public function stream(): StreamInterface
    {
        $streamFactory = new PsrFactory();
        if ($this->metadata()->mightHaveFrontMatter()) {
            return $streamFactory->createStream(
                Markdown::markdownConverter()->convert($this->contents())
            );

        }
        return $streamFactory->createStreamFromFile($this->file()->path());
    }






    public function isNotXml(): bool
    {
        return $this->mimetype()->isNotXml();
    }

    /**
     * @todo: verify can be deprecated
     */
    // public function isMarkdown(): bool
    // {
    //     return str_ends_with($this->fileName(), '.md');
    // }

    // public function found(): bool
    // {
    //     return file_exists($this->path()) and is_file($this->path());
    // }

    // public function isNotFound(): bool
    // {
    //     return ! $this->found();
    // }

    public function created(string $format = ''): string|int|false
    {
        return $this->dateField('created', $format);
    }

    public function updated(string $format = ''): string|int|false
    {
        return $this->dateField('updated', $format);
    }

    public function moved(string $format = ''): string|int|false
    {
        return $this->dateField('moved', $format);
    }

    /* @todo: Need testing to avoid regression */
    public function redirect(): object|false
    {
        if ($this->frontMatterHasMember('redirect')) {
            $redirect = strval($this->frontMatter['redirect']);
            list($code, $destination) = explode(' ', $redirect, 2);
            return (object) [
                'code'        => intval($code),
                'destination' => strval($destination)
            ];
        }
        return false;
    }

    private function dateField(
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

    public function description(): string
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

        $description = htmlentities(substr($description, 0, 200));

        $parts = explode('. ', $description);
        $description = '';
        foreach ($parts as $part) {
            $d = $part;
            if (strlen($description) > 0) {
                $d = $description . '. ' . $part;
            }

            $proposedLength = strlen($d);
            if ($proposedLength >= 200) {
                $ps = explode('. ', $d);
                array_pop($ps);
                $description = implode('. ', $ps) . '.';
                break;
            }
            $description = $d;
        }

        return $description;
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
        return $this->metadata()->frontMatter();
    }

    /**
     * @todo: move to trait
     */
    // public function path(bool $full = true): string
    // {
    //     if ($full) {
    //         return $this->localPath;
    //     }
    //     // TODO: test and verify used - returning empty string not an option.
    //     return str_replace($this->root, '', $this->localPath);
    // }

    public function canonicalUrl(): string
    {
        return str_replace(
            $this->contentFileName,
            '',
            ServerGlobals::init()->appUrl() . $this->path(false)
        );
    }

    public function parentFolder(): string
    {
        $path = $this->path(false);
        if (str_starts_with($path, '/')) {
            $path = substr($path, 1, strlen($path) - 1);
        }

        $parts = explode('/', $path);
        if (in_array('content.md', $parts)) {
            $parts = array_slice($parts, 0, count($parts) - 1);
        }

        $folder = array_pop($parts);
        if (! $folder) {
            return '';
        }
        return $folder;
    }

    public function title(): string
    {
        return $this->metadata()->title();
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
        if (
            strlen($this->contents) === 0 and
            $this->metadata()->mightHaveFrontMatter()
        ) {
            $contents = file_get_contents($this->path());
            $parts    = explode(
                FileMetadata::FRONT_MATTER_DELIMETER,
                $contents
            );

            if (count($parts) === 1) {
                $this->contents = ltrim($parts[0]);

            } elseif (count($parts) === 3) {
                $this->contents = ltrim($parts[2]);

            }
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
            $this->root
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
                $this->root
            );
        }
        return $files;
    }
}
