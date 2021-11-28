<?php

declare(strict_types=1);
//
// use JoshBruce\SiteDynamic\Http\Responses\File as FileResponse;
//
// use Psr\Http\Message\StreamInterface;
//
// beforeEach(function() {
//    $path = __DIR__ . '/../../../../content/public';
//    $fileInfo = new \SplFileInfo($path);
//
//    $this->publicRoot = $fileInfo->getRealPath();
//
//    $this->mainCssPath = $this->publicRoot . '/assets/css/main.min.css';
// });
//
// it('has expected status code', function() {
//     expect(
//         FileResponse::at($this->mainCssPath, 'text/css')
//             ->statusCode()
//     )->toBeInt()->toBe(200);
// })->group('response', 'file-response');
//
// it('has expected headers', function() {
//     expect(
//         FileResponse::at($this->mainCssPath, 'text/css')
//             ->headers()
//     )->toBeArray()->toBe([
//         'Content-type' => 'text/css'
//     ]);
// })->group('response', 'file-response');
//
// test('stream is resource', function() {
//     expect(
//         FileResponse::at($this->mainCssPath, 'text/css')
//             ->stream()
//     )->toBeInstanceOf(
//         StreamInterface::class
//     );
// })->group('response', 'file-response');
