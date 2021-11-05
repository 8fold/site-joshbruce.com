<?php

use JoshBruce\Site\FileSystem;

beforeEach(function() {
    // This somewhat unreadable one-liner basically creates a fully qualified
    // path to the root of the project, without using relative syntax
    $this->projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

    serverGlobals();

    $this->contentRoot = $this->projectRoot . $_SERVER['CONTENT_FOLDER'];
});

it('can return folder tree', function() {
    $this->assertEquals(
        FileSystem::init($this->contentRoot)
            ->with(folderPath: '/sub-folder')->folderStack(),
        [
            FileSystem::init($this->contentRoot)->with(folderPath: '/sub-folder'),
            FileSystem::init($this->contentRoot)->with(folderPath: '')
        ]
    );

    $this->assertEquals(
        FileSystem::init($this->contentRoot)
            ->with(folderPath: '/sub-folder')
            ->folderStack(fileName: 'content.md'),
        [
            FileSystem::init($this->contentRoot)->with(
                folderPath: '/sub-folder',
                fileName: 'content.md'
            ),
            FileSystem::init($this->contentRoot)
                ->with(folderPath: '', fileName: 'content.md')
        ]
    );
})->group('filesystem');

it('can determine if path is content root', function() {
    expect(
        FileSystem::init($this->contentRoot)->isRoot()
    )->toBeTrue();

    expect(
        FileSystem::init($this->contentRoot, '/not-there')->isRoot()
    )->toBeFalse();

    expect(
        FileSystem::init($this->contentRoot)->isNotRoot()
    )->toBeFalse();

    expect(
        FileSystem::init($this->contentRoot, '/not-there')->isNotRoot()
    )->toBeTrue();
})->group('filesystem');

it('can determine if path exists', function() {
    expect(
        FileSystem::init($this->contentRoot)->found()
    )->toBeTrue();

    expect(
        FileSystem::init($this->contentRoot . '/not-there')->found()
    )->toBeFalse();

    expect(
        FileSystem::init($this->contentRoot)->notFound()
    )->toBeFalse();

    expect(
        FileSystem::init($this->contentRoot . '/not-there')->notFound()
    )->toBeTrue();
})->group('filesystem');

it('can detect whether the root folder exists', function() {
   expect(
       FileSystem::init($this->contentRoot)->rootFolderIsMissing()
   )->toBeFalse();

   expect(
      FileSystem::init($this->contentRoot . '/not-there')->rootFolderIsMissing()
  )->toBeTrue();
})->group('filesystem');

it('has correct file path', function() {
    expect(
        FileSystem::init($this->contentRoot)->with(
            folderPath: '/assets/js',
            fileName: 'javascript.js'
        )->path()
    )->toBe(
        __DIR__ . '/test-content/content/assets/js/javascript.js'
    );

    expect(
        FileSystem::init($this->contentRoot)->navigation('main.md')->path()
    )->toBe(
        __DIR__ . '/test-content/navigation/main.md'
    );

    expect(
        FileSystem::init($this->contentRoot)->messages('original.md')->path()
    )->toBe(
        __DIR__ . '/test-content/messages/original.md'
    );

    expect(
        FileSystem::init($this->contentRoot)->messages()->path()
    )->toBe(
        __DIR__ . '/test-content/messages'
    );

    expect(
        FileSystem::init($this->contentRoot, '/sub-folder', 'content.md')
            ->path(false)
    )->toBe(
        '/sub-folder/content.md'
    );
})->group('filesystem');

it('has the correct content root', function() {
    expect(
        FileSystem::init($this->contentRoot)->contentRoot()
    )->toBe(
        __DIR__ . '/test-content/content'
    );
})->group('filesystem');

it('has correct mimetypes', function() {
    // https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/
    // MIME_types#textjavascript
    expect(
        FileSystem::init($this->contentRoot)->with(
            folderPath: '/assets/js',
            fileName: 'javascript.js'
        )->mimetype()
    )->toBe(
        'text/javascript'
    );

    expect(
        FileSystem::init($this->contentRoot)->with(
            folderPath: '/assets/css',
            fileName: 'main.css'
        )->mimetype()
    )->toBe(
        'text/css'
    );

    expect(
        FileSystem::init($this->contentRoot)->with(
            folderPath: '/',
            fileName: 'content.md'
        )->mimetype()
    )->toBe(
        'text/html'
    );
})->group('filesystem');
