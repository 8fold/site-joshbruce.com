<?php

use JoshBruce\Site\FileSystem;

beforeEach(function() {
    // This somewhat unreadable one-liner basically creates a fully qualified
    // path to the root of the project, without using relative syntax
    $projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

    $this->fileSystem = FileSystem::init(
        projectRoot: $projectRoot,
        contentUp: 0,
        contentFolder: '/tests/test-content'
    );
});

it('has file and folder paths', function() {

});

it('has correct mimetypes', function() {
    // https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/
    // MIME_types#textjavascript
    expect(
        $this->fileSystem->with(path: '/.assets/javascript.js')->mimetype()
    )->toBe(
        'text/javascript'
    );

    expect(
        $this->fileSystem->with(path: '/.assets/main.css')->mimetype()
    )->toBe(
        'text/css'
    );

    expect(
        $this->fileSystem->with(path: '/content.md')->mimetype()
    )->toBe(
        'text/html'
    );

})->group('content');
