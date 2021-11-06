<?php

use JoshBruce\Site\Content\Markdown;

use JoshBruce\Site\FileSystem;

use JoshBruce\Site\Content\FrontMatter;

it('can return front matter', function() {
    expect(
        Markdown::init(
            FileSystem::public('content.md')
        )->frontMatter()
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
