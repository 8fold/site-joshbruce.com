<?php

use JoshBruce\Site\Content;

// beforeEach(function() {
//     // This somewhat unreadable one-liner basically creates a fully qualified
//     // path to the root of the project, without using relative syntax
//     $projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

//     $this->baseContent = Content::init(
//         projectRoot: $projectRoot,
//         contentUp: 0,
//         contentFolder: '/tests/test-content'
//     );
// });

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
