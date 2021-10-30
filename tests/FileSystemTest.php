<?php

use JoshBruce\Site\FileSystem;

beforeEach(function() {
    // This somewhat unreadable one-liner basically creates a fully qualified
    // path to the root of the project, without using relative syntax
    $this->projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

    $this->contentRoot = $this->projectRoot . '/tests/test-content';

    $this->fileSystem = FileSystem::init(
        projectRoot: $this->projectRoot,
        contentUp: 0,
        contentFolder: '/tests/test-content'
    );
});

it('can return folder tree', function() {
    $this->assertEquals(
        $this->fileSystem->with(path: '/sub-folder')->folderStack(),
        [
            $this->fileSystem->with(path: '/sub-folder'),
            $this->fileSystem->with(path: '')
        ]
    );

    $this->assertEquals(
        $this->fileSystem->with(path: '/sub-folder')
            ->folderStack(fileName: 'content.md'),
        [
            $this->fileSystem->with(
                path: '/sub-folder',
                fileName: 'content.md'
            ),
            $this->fileSystem->with(path: '', fileName: 'content.md')
        ]
    );
})->group('filesystem');

it('has file and folder paths', function() {
    expect(
        $this->fileSystem->with(
            path: '/sub-folder',
            fileName: 'content.md'
        )->filePath()
    )->toBe(
        $this->contentRoot . '/sub-folder/content.md'
    );

    expect(
        $this->fileSystem->with(
            path: '/sub-folder',
            fileName: 'content.md'
        )->folderPath()
    )->toBe(
        $this->contentRoot . '/sub-folder'
    );
})->group('filesystem');

it('has correct mimetypes', function() {
    // https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/
    // MIME_types#textjavascript
    expect(
        $this->fileSystem->with(
            path: '/.assets',
            fileName: 'javascript.js'
        )->mimetype()
    )->toBe(
        'text/javascript'
    );

    expect(
        $this->fileSystem->with(
            path: '/.assets',
            fileName: 'main.css'
        )->mimetype()
    )->toBe(
        'text/css'
    );

    expect(
        $this->fileSystem->with(
            path: '/',
            fileName: 'content.md'
        )->mimetype()
    )->toBe(
        'text/html'
    );

})->group('filesystem');
