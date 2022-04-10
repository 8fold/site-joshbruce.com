<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

// use DateTime;
use SplFileInfo;
//
// use Symfony\Component\Yaml\Yaml;
//
// use JoshBruce\SiteDynamic\Content\Markdown;
//
// use JoshBruce\SiteDynamic\Documents\HtmlDefault;
//
use JoshBruce\SiteDynamic\FileSystem\PlainTextTrait;

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

class PlainTextFileFromAlias
{
    use PlainTextTrait;

    private const FRONT_MATTER_DELIMITER = '---';

    /**
     * @var array<string, mixed>
     */
    // private array $frontMatter = [];

    // private string $content = '';

    /**
     * @var string[]
     */
    // private array $titleParts = [];

    public static function at(
        string $localPath,
        string $root,
        PlainTextFile $original
    ): PlainTextFileFromAlias {
        $realPath = (new SplFileInfo($root))->getRealPath();
        if (! $realPath) {
            $realPath = $root;
        }
        return static::from(
            new SplFileInfo($localPath),
            $realPath,
            $original
        );
    }

    public static function from(
        SplFileInfo $fileInfo,
        string $root,
        PlainTextFile $original
    ): PlainTextFileFromAlias {
        return new static($fileInfo, $root, $original);
    }

    final private function __construct(
        private SplFileInfo $fileInfo,
        private string $root,
        private $original
    ) {
    }

    private function original(): PlainTextFile
    {
        return $this->original;
    }
    // public function hasMetadata(string $key): bool
    // {
    //     $frontMatter = $this->frontMatter();
    //     return array_key_exists($key, $frontMatter);
    // }

    // public function template(): string
    // {
    //     $frontMatter = $this->frontMatter();
    //     if (
    //         array_key_exists('template', $frontMatter) and
    //         $template = $frontMatter['template'] and
    //         is_string($template)
    //     ) {
    //         return $template;
    //     }
    //     return '';
    // }

    // public function alias(): bool|string
    // {
    //     $frontMatter = $this->frontMatter();
    //     if (
    //         array_key_exists('alias', $frontMatter) and
    //         $path = $frontMatter['alias'] and
    //         is_string($path)
    //     ) {
    //         return $path;
    //     }
    //     return false;
    // }

    // public function title(): string
    // {
    //     $frontMatter = $this->frontMatter();
    //     if (
    //         array_key_exists('title', $frontMatter) and
    //         $title = $frontMatter['title'] and
    //         $title = strval($title)
    //     ) {
    //         return htmlspecialchars(
    //             strip_tags(
    //                 trim(Markdown::titleConverter()->convert($title))
    //             )
    //         );
    //     }
    //     return '';
    // }

    public function pageTitle(): string
    {
        return $this->original()->pageTitle();
        // $parts = array_filter($this->titleParts());
        // return implode(' | ', $parts);
    }

//     public function socialTitle(): string
//     {
//         $titles = $this->titleParts();
//
//         $t = [];
//         $t[] = array_shift($titles);
//         if (count($titles) > 0) {
//             $t[] = array_pop($titles);
//         }
//         return implode(' | ', $t);
//     }

    // public function created(string $format = ''): string|int|false
    // {
    //     return $this->dateField('created', $format);
    // }

    // public function moved(string $format = ''): string|int|false
    // {
    //     return $this->dateField('moved', $format);
    // }

    // public function updated(string $format = ''): string|int|false
    // {
    //     return $this->dateField('updated', $format);
    // }

    // public function original(): string
    // {
    //     $frontMatter = $this->frontMatter();
    //     if (
    //         array_key_exists('original', $frontMatter) and
    //         $original = $frontMatter['original'] and
    //         is_string($original)
    //     ) {
    //         return $original;
    //     }
    //     return '';
    // }

    /**
     * @return array<string, mixed>
     */
    // public function frontMatter(): array
    // {
    //     if (count($this->frontMatter) === 0) {
    //         $this->processRawContent();
    //     }
    //     return $this->frontMatter;
    // }

    // public function content(): string
    // {
    //     if (strlen($this->content) === 0) {
    //         $this->processRawContent();
    //     }
    //     return $this->content;
    // }

//     public function description(): string
//     {
//         $description = '';
//
//         $frontMatter = $this->frontMatter();
//         if (array_key_exists('description', $frontMatter)) {
//             $description = $frontMatter['description'];
//
//         } else {
//             // Remove headings and partials and collapse
//             $description = $this->content();
//
//             $check = preg_filter(
//                 ["/#(.*)\n/", "/{!!(.*)!!}/"],
//                 ['', ''],
//                 $description
//             );
//
//             if ($check !== null and is_string($check)) {
//                 $description = $check;
//             }
//
//             $blocks = explode("\n", $description);
//             $contentBlocks = array_filter($blocks);
//
//             $description = implode(' ', $contentBlocks);
//         }
//
//         if (! is_string($description)) {
//             $description = '';
//         }
//
//         $description = strip_tags(
//             Markdown::markdownConverter()->convert(
//                 substr($description, 0, 400)
//             )
//         );
//
//         $sentences = explode('. ', $description);
//
//         $description = '';
//         foreach ($sentences as $sentence) {
//             $d = $sentence;
//             if (strlen($description) > 0) {
//                 $d = $description . '. ' . $sentence;
//             }
//
//             $proposedLength = strlen($d);
//             if ($proposedLength >= 200) {
//                 $ps = explode('. ', $d);
//                 array_pop($ps);
//                 $description = implode('. ', $ps) . '.';
//                 break;
//             }
//             $description = $d;
//         }
//
//         return $description;
//     }

    /**
     * @return array<int, int[]>
     */
    // public function data(): array
    // {
    //     $frontMatter = $this->frontMatter();
    //     if (
    //         array_key_exists('data', $frontMatter) and
    //         $data = $frontMatter['data'] and
    //         is_array($data)
    //     ) {
    //         return $data;
    //     }
    //     return [];
    // }

    /**
     * @return array<int, int[]|float[]>
     */
    // public function fiExperiments(): array
    // {
    //     $frontmatter = $this->frontMatter();
    //     if (
    //         array_key_exists('fi-experiments', $frontmatter) and
    //         $data = $frontmatter['fi-experiments'] and
    //         is_array($data)
    //     ) {
    //         return $data;
    //     }
    //     return [];
    // }

    /**
     * @return string[]
     */
//     private function titleParts(): array
//     {
//         if (count($this->titleParts) === 0) {
//             $path = $this->path(omitFilename: true);
//
//             $titles = [];
//             $titles[] = $this->title();
//             while (str_contains($path, $this->root)) {
//
//                 $parts = explode('/', $path);
//
//                 $parts = array_slice($parts, 0, -1);
//
//                 $path  = implode('/', $parts);
//
//                 if (str_contains($path, $this->root)) {
//                     $titles[] = PlainTextFile::at($path . '/content.md', $this->root)
//                         ->title();
//
//                 }
//             }
//
//             $this->titleParts = $titles;
//         }
//         return $this->titleParts;
//     }

//     private function dateField(
//         string $key,
//         string $format = ''
//     ): string|int|false {
//         $frontMatter = $this->frontMatter();
//         if (array_key_exists($key, $frontMatter)) {
//             $date = $frontMatter[$key];
//
//             if (strlen($format) === 0) {
//                 return intval($date);
//             }
//
//             if ($date = DateTime::createFromFormat('Ymd', strval($date))) {
//                 return $date->format($format);
//             }
//         }
//         return false;
//     }

//     private function processRawContent(): void
//     {
//         $contents = file_get_contents($this->path());
//
//         if (is_string($contents)) {
//             $parts = explode(self::FRONT_MATTER_DELIMITER, $contents);
//             if (
//                 count($parts) === 3 and
//                 $possible = Yaml::parse($parts[1]) and
//                 is_array($possible)
//             ) {
//                 $this->frontMatter = $possible;
//                 $this->content = $parts[2];
//
//             } else {
//                 $this->content = $parts[0];
//
//             }
//         }
//     }
}
