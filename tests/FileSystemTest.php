<?php

use JoshBruce\Site\FileSystem;

use JoshBruce\Site\File;

beforeEach(function() {
    // This somewhat unreadable one-liner basically creates a fully qualified
    // path to the root of the project, without using relative syntax
    $this->projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

    serverGlobals();

    $this->contentRoot = $this->projectRoot . '/content';
});

test('content folder does exist', function() {
    expect(
        FileSystem::contentFolderIsMissing()
    )->toBeFalse();
})->group('filesystem');

it('can initialize folders', function() {
   expect(
        FileSystem::public()->path()
   )->toBeString()->toBe(
        "{$this->contentRoot}/public"
   );

   expect(
       FileSystem::navigation()->path()
    )->toBeString()->toBe(
       "{$this->contentRoot}/navigation"
    );
})->group('filesystem');

// it('can return folder tree', function() {
//     $this->assertEquals(
//         FileSystem::init(
//             $this->contentRoot,
//             'public',
//             'finances',
//             'investment-policy'
//         )->folderStack(),
//         [
//             FileSystem::init(
//                 $this->contentRoot,
//                 'public',
//                 'finances',
//                 'investment-policy'
//             ),
//             FileSystem::init(
//                 $this->contentRoot,
//                 'public',
//                 'finances'
//             ),
//             FileSystem::init(
//                 $this->contentRoot,
//                 'public'
//             ),
//             FileSystem::init(
//                 $this->contentRoot
//             )
//         ]
//     );
//
//     $this->assertEquals(
//         FileSystem::init($this->contentRoot)
//             ->with(folderPath: '/sub-folder')
//             ->folderStack(fileName: 'content.md'),
//         [
//             FileSystem::init($this->contentRoot)->with(
//                 folderPath: '/sub-folder',
//                 fileName: 'content.md'
//             ),
//             FileSystem::init($this->contentRoot)
//                 ->with(folderPath: '', fileName: 'content.md')
//         ]
//     );
// })->group('filesystem', 'focus');
//
// it('can determine if path is content root', function() {
//     expect(
//         FileSystem::init($this->contentRoot)->isRoot()
//     )->toBeTrue();
//
//     expect(
//         FileSystem::init($this->contentRoot, '/not-there')->isRoot()
//     )->toBeFalse();
//
//     expect(
//         FileSystem::init($this->contentRoot)->isNotRoot()
//     )->toBeFalse();
//
//     expect(
//         FileSystem::init($this->contentRoot, '/not-there')->isNotRoot()
//     )->toBeTrue();
// })->group('filesystem');

// it('can determine if path exists', function() {
//     expect(
//         FileSystem::init($this->contentRoot)->found()
//     )->toBeTrue();
//
//     expect(
//         FileSystem::init($this->contentRoot . '/not-there')->found()
//     )->toBeFalse();
//
//     expect(
//         FileSystem::init($this->contentRoot)->notFound()
//     )->toBeFalse();
//
//     expect(
//         FileSystem::init($this->contentRoot . '/not-there')->notFound()
//     )->toBeTrue();
// })->group('filesystem');
//
// it('can detect whether the root folder exists', function() {
//    expect(
//        FileSystem::init($this->contentRoot)->rootFolderIsMissing()
//    )->toBeFalse();
//
//    expect(
//       FileSystem::init($this->contentRoot . '/not-there')->rootFolderIsMissing()
//   )->toBeTrue();
// })->group('filesystem');
//
// it('has correct file path', function() {
//     expect(
//         FileSystem::init($this->contentRoot, 'css', 'main.min.css')->path()
//     )->toBe(
//         "{$this->contentRoot}/css/main.min.css"
//     );
//
//     expect(
//         FileSystem::init($this->contentRoot)->navigation('main.md')->path()
//     )->toBe(
//         "{$this->contentRoot}/navigation/main.md"
//     );
//
//     expect(
//         FileSystem::init($this->contentRoot)->messages('original.md')->path()
//     )->toBe(
//         "{$this->contentRoot}/messages/original.md"
//     );
//
//     expect(
//         FileSystem::init($this->contentRoot)->messages()->path()
//     )->toBe(
//         "{$this->contentRoot}/messages"
//     );
//
//     expect(
//         FileSystem::init($this->contentRoot, 'public', 'legal', 'content.md')
//             ->path(false)
//     )->toBe(
//         '/public/legal/content.md'
//     );
// })->group('filesystem');
//
// it('has correct mimetypes', function() {
//     // https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/
//     // MIME_types#textjavascript
//     expect(
//         FileSystem::init($this->contentRoot, 'gulpfile.js')->mimetype()
//     )->toBe(
//         'text/javascript'
//     );
//
//     expect(
//         FileSystem::init($this->contentRoot, 'css', 'main.min.css')->mimetype()
//     )->toBe(
//         'text/css'
//     );
//
//     expect(
//         FileSystem::init($this->contentRoot, 'public', 'content.md')->mimetype()
//     )->toBe(
//         'text/html'
//     );
// })->group('filesystem');
