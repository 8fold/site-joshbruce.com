<?php

declare(strict_types=1);

use JoshBruce\Site\FileSystem;
use JoshBruce\Site\File;

beforeEach(function() {
    $this->published = FileSystem::init()->publishedContentFinder()->in(
        FileSystem::init()->publicRoot()
    );

    $this->redirected = FileSystem::init()->redirectedContentFinder()->in(
        FileSystem::init()->publicRoot()
    );

});

test('public folder exists', function() {
    expect(
       is_dir(FileSystem::init()->publicRoot())
    )->toBeTrue();
})->group('live-content');

test('all content should have a title', function() {
    foreach ($this->published as $splFileInfo) {
        $file = File::at($splFileInfo->getPathName(), FileSystem::init());
        $title = $file->title();

        $this->assertTrue(strlen($title) > 0, $file->path());
    }
})->group('live-content');

test('redirected content uses tilde', function() {
    foreach ($this->redirected as $splFileInfo) {
        $file = File::at($splFileInfo->getPathName(), FileSystem::init());
        $path = $file->path(false);

        $parentFolder = $file->parentFolder();
        if (strlen($parentFolder) > 0) {
            // The parent folder should begin with a tilde to visually indicate
            // that the content redirects somewhere else.
            // var_dump($parentFolder);
            $this->assertTrue(
                str_starts_with($parentFolder, '~'),
                $file->path()
            );
        }

        $fileName = $file->filename();
        $this->assertTrue(
            str_starts_with($fileName, '~'),
            $file->path()
        );
    }
})->group('live-content');

test('redirected content has code and path', function() {
    foreach ($this->redirected as $splFileInfo) {
        $file = File::at($splFileInfo->getPathName(), FileSystem::init());
        $redirect = $file->redirect();

        $this->assertEquals($redirect->code, 301, $file->path());
    }
})->group('live-content');

test('redirected content only hops once', function() {
    // TODO: Thinking there should be something like a HttpRedirect object
    //       it would be able to handle multiple jumps - returning a file
    //       HttpRequest. If too many redirects, could use 310 as I believe
    //       that's what Chrome sends back on too many redirects error.
    foreach ($this->redirected as $splFileInfo) {
        $file = File::at($splFileInfo->getPathName(), FileSystem::init());
        $destination = $file->redirect()->destination;

        $path = FileSystem::init()->publicRoot() . $destination;
        $destinationFile = File::at($path, FileSystem::init());

        $this->assertFalse($destinationFile->redirect());
    }
})->group('live-content');

test('all URL references are reachable', function() {
    // TODO: Check rendered pages for paths and verify those paths result in
    //       status 200 requests and responses.
});
