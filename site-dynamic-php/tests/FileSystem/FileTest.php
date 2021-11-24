<?php

declare(strict_types=1);
//
// use JoshBruce\SiteDynamic\FileSystem\File;
//
// use JoshBruce\SiteDynamic\FileSystem\Finder;
//
// use JoshBruce\SiteDynamic\Tests\Extensions\FileSystem\Finder as TestFinder;
//
// beforeEach(function() {
//     $this->publicRoot = Finder::init()->publicRoot();
//     $this->rootContentPath = $this->publicRoot . '/content.md';
//     $this->mainCssPath = $this->publicRoot . '/assets/css/main.min.css';
//
//     $this->testContentPublicRoot = TestFinder::init()->publicRoot();
//     $this->rootTestContentPath = $this->testContentPublicRoot . '/content.md';
//
// });
//
// test('can instantiate file', function() {
//     expect(
//         File::at(
//             $this->rootContentPath,
//             $this->publicRoot
//         )
//     )->toBeInstanceOf(
//         File::class
//     );
// })->group('file', 'live-content');
//
// test('can get file info', function() {
//     expect(
//         File::at($this->rootContentPath, $this->publicRoot)
//             ->extension()
//     )->toBeString()->toBe(
//         'md'
//     );
//
//     expect(
//         File::at($this->rootContentPath, $this->publicRoot)
//             ->filename()
//     )->toBeString()->toBe(
//         'content.md'
//     );
//
//     expect(
//         File::at($this->rootContentPath, $this->publicRoot)
//             ->filename(false)
//     )->toBeString()->toBe(
//         'content'
//     );
//
//     expect(
//         File::at($this->rootContentPath, $this->publicRoot)
//             ->path()
//     )->toBeString()->toBe(
//         $this->publicRoot . '/content.md'
//     );
//
//     expect(
//         File::at($this->rootContentPath, $this->publicRoot)
//             ->path(omitFilename: true)
//     )->toBeString()->toBe(
//         $this->publicRoot
//     );
//
//     expect(
//         File::at($this->rootContentPath, $this->publicRoot)
//             ->mimetype()->raw()
//     )->toBeString()->toBe(
//         'text/plain'
//     );
//
//     expect(
//         File::at($this->rootContentPath, $this->publicRoot)
//             ->mimetype()->interpreted()
//     )->toBeString()->toBe(
//         'text/html'
//     );
//
//     expect(
//         File::at($this->mainCssPath, $this->publicRoot)
//             ->mimetype()->interpreted()
//     )->toBeString()->toBe(
//         'text/css'
//     );
//
//     expect(
//         File::at($this->mainCssPath, $this->publicRoot)
//             ->mimetype()->category()
//     )->toBeString()->toBe(
//         'text'
//     );
//
//     expect(
//         File::at($this->mainCssPath, $this->publicRoot)
//             ->mimetype()->name()
//     )->toBeString()->toBe(
//         'css'
//     );
// })->group('file', 'live-content');
//
// test('can get title', function() {
//     expect(
//         File::at(
//             $this->rootContentPath,
//             $this->publicRoot
//         )->title()
//     )->toBeString()->toBe(
//         "Josh Bruce’s personal site"
//     );
// })->group('file', 'live-content');
//
// test('can get file content', function() {
//     expect(
//         File::at(
//             $this->rootTestContentPath,
//             $this->testContentPublicRoot
//         )->contents()
//     )->toBeString()->toBe(<<<md
//         Root test content, with front matter.
//
//         md
//     );
//
//     expect(
//         File::at(
//             $this->testContentPublicRoot . '/without-front-matter/content.md',
//             $this->testContentPublicRoot
//         )->contents()
//     )->toBeString()->toBe(<<<md
//         Test content without front matter.
//
//         md
//     );
// })->group('file', 'test-content');
