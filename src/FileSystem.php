<?php

declare(strict_types=1);

namespace JoshBruce\Site;
//
// use DirectoryIterator;
//
// use JoshBruce\Site\Content\FrontMatter;
//
// use JoshBruce\Site\SiteDynamic\Server;
// use JoshBruce\Site\Folder;
//
/**
 * A factory class to make accessing project folders easier.
 */
class FileSystem
{
//     public static function public(string $file = ''): Folder|File
//     {
//         $folder = self::folder(named: 'public');
//         if (strlen($file) === 0) {
//             return $folder;
//         }
//         return self::file(named: $file, in: $folder);
//     }
//
//     public static function navigation(string $file = ''): Folder|File
//     {
//         $folder = self::folder(named: 'navigation');
//         if (strlen($file) === 0) {
//             return $folder;
//         }
//         return self::file(named: $file, in: $folder);
//     }
//
//     public static function messages(): Folder
//     {
//         return self::folder(named: 'messages');
//     }
//
//     public static function media(): Folder
//     {
//         return self::folder(named: 'media');
//     }
//
//     public static function assets(): Folder
//     {
//         return self::folder(named: 'assets');
//     }
//
//     public static function contentFolderIsMissing(): bool
//     {
//         return ! self::contentFolderWasFound();
//     }
//
    public static function contentRoot(): string
    {
        $parts   = explode('/', self::projectRoot());
        $parts[] = 'content';
        $base    = implode('/', $parts);
        if (str_ends_with($base, '/')) {
            $base = substr($base, 0, -1);
        }
        return $base;
    }

    private static function projectRoot(): string
    {
        $dir   = __DIR__;
        $parts = explode('/', $dir);
        $parts = array_slice($parts, 0, -1);
        return implode('/', $parts);
    }

//
//     private static function folder(string $named): Folder
//     {
//         $base = self::base();
//         return Folder::init("{$base}/{$named}");
//     }
//
//     private static function file(string $named, Folder $in): File
//     {
//         $path = "{$in->path()}/{$named}";
//         return File::init($path);
//     }
//
//     private static function contentFolderWasFound(): bool
//     {
//         return file_exists(self::base()) or is_dir(self::base());
//     }
// //     public static function init(
// //         string $path = '', ...$parts
// //         // string $contentRoot,
// //         // string $folderPath = '/',
// //         // string $fileName = ''
// //     ): FileSystem|File {
// //         $last = array_pop($parts);
// //
// //         $p       = explode('/', $path);
// //         $parts   = array_merge($p, $parts);
// //         $parts[] = $last;
// //         $path    = implode('/', $parts);
// //         if (is_string($last) and str_contains($last, '.')) {
// //             return File::init($path);
// //         }
// //
// //         if (str_ends_with($path, '/')) {
// //             $path = substr($path, 0, -1);
// //         }
// //
// //         return new FileSystem(
// //             $path
// //             // $contentRoot,
// //             // $folderPath,
// //             // $fileName
// //         );
// //     }
// //
// //     public function __construct(
// //         private string $path = ''
// //         // private string $contentRoot,
// //         // private string $folderPath = '/',
// //         // private string $fileName = ''
// //     ) {
// //     }
//
// //     public function base(): string
// //     {
// //
// //     }
//
// //     public function with(string $fileName = ''): FileSystem
// //     {
// //
// //         return new self($this->contentRoot(), $fileName);
// //     }
//
//     // public function fileNamed(string $fileName): FileSystem
//     // {
//     //     return $this->with($this->folderPath, $fileName);
//     // }
//
//     // public function fileName(): string
//     // {
//     //     return $this->fileName;
//     // }
//
//     // public function path(): string
//     // {
//     //     return $this->path;
//     // }
//
// //     public function mimetype(): string
// //     {
// //         $type = mime_content_type($this->path());
// //         if (is_bool($type) and $type === false) {
// //             return '';
// //         }
// //
// //         if ($type === 'text/plain') {
// //             $extensionMap = [
// //                 'md'  => 'text/html',
// //                 'css' => 'text/css',
// //                 'js'  => 'text/javascript'
// //             ];
// //
// //             $parts     = explode('.', $this->path());
// //             $extension = array_pop($parts);
// //
// //             $type = $extensionMap[$extension];
// //         }
// //         return $type;
// //     }
//
//     // private function local(
//     //     string $folder,
//     //     string $withFile = ''
//     // ): FileSystem|File {
//     //     if (strlen($withFile) === 0) {
//     //         return FileSystem::init("{$this->path()}/{$folder}");
//     //     }
//     //     $base = $this->local($folder)->path();
//     //     return File::init("{$base}/{$withFile}");
//     // }
//
//     // public function public(string $file = ''): FileSystem|File
//     // {
//     //     return $this->local(folder: 'public', withFile: $file);
//     // }
//
//     // public function navigation(string $file = ''): FileSystem|File
//     // {
//     //     return $this->local(folder: 'navigation', withFile: $file);
//     //     // return $this->local('navigation', $file);
//     //     // if (strlen($file) > 0) {
//     //     //     return File::init("{$this->base()}/navigation/{$file}");
//     //     // }
//     //     // return FileSystem::init("{$this->base()}/navigation");
//     // }
//
//     // public function messages(string $file = ''): FileSystem|File
//     // {
//     //     return $this->local(folder: 'messages', withFile: $file);
//     //     // return $this->local('messages', $file);
//     //     // if (strlen($file) === 0) {
//     //     //     return FileSystem::init("{$this->base()}/messages");
//     //     // }
//     //     // $base = $this->messages()->path();
//     //     // return File::init("{$base}/{$file}");
//     // }
//
//     // public function media(string $file = ''): FileSystem
//     // {
//     //     return $this->local(folder: 'media', withFile: $file);
//     //     // return $this->local('media', $file);
//     //     // return $this->up()->with('/media', $file);
//     // }
//
//     // public function assets(string $file = ''): FileSystem
//     // {
//     //     return $this->local(folder: 'assets', withFile: $file);
//     //     // return $this->local('assets', $file);
//     //     // return $this->up()->with('/assets', $file);
//     // }
//
//     // public function rootFolderIsMissing(): bool
//     // {
//     //     if (! file_exists($this->path())) {
//     //         return true;
//     //     }
//     //     return ! is_dir($this->path());
//     // }
//
// //     public function notFound(): bool
// //     {
// //         return ! $this->found();
// //     }
// //
// //     public function found(): bool
// //     {
// //         return file_exists($this->path());
// //     }
//
//     // public function isNotRoot(): bool
//     // {
//     //     return ! $this->isRoot();
//     // }
//
//     // public function isRoot(): bool
//     // {
//     //     $subtract = str_replace(
//     //         [$this->contentRoot(), '/content.md'],
//     //         ['', ''],
//     //         $this->path()
//     //     );
//     //     return strlen($subtract) === 0 or $subtract === '/';
//     // }
//
//     // public function isFile(): bool
//     // {
//     //     return file_exists($this->path()) and ! is_dir($this->path());
//     // }
//
//     /**
//      * @return FileSystem[]
//      */
// //     public function folderStack(string $fileName = ''): array
// //     {
// //         $folderPath = $this->path(false);
// //         if (! is_dir($folderPath)) {
// //             return [];
// //         }
// //
// //         $folderPath = str_replace($this->base(), '', $folderPath);
// //
// //         $folderPathParts = explode('/', $folderPath);
// //
// //         $folders = [];
// //         while (count($folderPathParts) > 0) {
// //             $folders[] = FileSystem::init($this->base(), ...$folderPathParts);
// //             // $path = implode('/', $folderPathParts);
// //
// // //             $clone = clone $this;
// // //             $clone = $clone->with(folderPath: $path, fileName: $fileName);
// // //
// // //             $folders[] = $clone;
// //
// //             array_pop($folderPathParts);
// //         }
// //         return $folders;
// //     }
//
//     /**
//      * @return array<string, FileSystem>
//      */
// //     public function subfolders(string $fileName = ''): array
// //     {
// //         $folderPath = $this->path();
// //         if (! is_dir($folderPath) and ! is_file($folderPath)) {
// //             return [];
// //
// //         } elseif (is_file($folderPath)) {
// //             $parts = explode('/', $folderPath);
// //             array_pop($parts);
// //             $folderPath = implode('/', $parts);
// //
// //         }
// //
// //         $content = [];
//         foreach (new DirectoryIterator($folderPath) as $folder) {
//             if ($folder->isFile() or $folder->isDot()) {
//                 continue;
//             }
//
//             $fullPathToFolder = $folder->getPathname();
//             $partialPath      = str_replace(
//                 $this->contentRoot(),
//                 '',
//                 $fullPathToFolder
//             );
//
//             $parts = explode('/', $partialPath);
//
//             $folderName = array_pop($parts);
//
//             $clone = clone $this;
//             $content[$folderName] = $clone->with($partialPath, $fileName);
//         }
//         return $content;
// //     }
//
//     // private function up(): FileSystem
//     // {
//     //     $parts = explode('/', $this->base());
//     //     array_pop($parts);
//     //     $newRoot = implode('/', $parts);
//     //     return FileSystem::init($newRoot);
//     // }
}
