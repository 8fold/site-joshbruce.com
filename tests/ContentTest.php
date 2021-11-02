<?php

use JoshBruce\Site\Content\Markdown;

use JoshBruce\Site\FileSystem;

use JoshBruce\Site\Content\FrontMatter;

beforeEach(function() {
    // This somewhat unreadable one-liner basically creates a fully qualified
    // path to the root of the project, without using relative syntax
    $this->projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

    $this->contentRoot = $this->projectRoot . '/tests/test-content';

    $this->fileSystem = FileSystem::init(
        contentRoot: $this->contentRoot,
        folderPath: '/tests/test-content'
    );

    $this->file = $this->fileSystem->with(
        folderPath: '',
        fileName: 'content.md'
    );
});

it('can return front matter', function() {
    expect(
        Markdown::init($this->file)->frontMatter()
    )->toBeInstanceOf(
        FrontMatter::class
    );
});



// it('has correct mimetypes', function() {
//     // https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/
//     // MIME_types#textjavascript
//     expect(
//         $this->baseContent->for(path: '/.assets/javascript.js')->mimetype()
//     )->toBe(
//         'text/javascript'
//     );

//     expect(
//         $this->baseContent->for(path: '/.assets/main.css')->mimetype()
//     )->toBe(
//         'text/css'
//     );

//     expect(
//         $this->baseContent->for(path: '/content.md')->mimetype()
//     )->toBe(
//         'text/html'
//     );

// })->group('content');
