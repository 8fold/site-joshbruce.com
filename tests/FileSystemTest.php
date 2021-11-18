<?php

use JoshBruce\Site\Tests\TestFileSystem;

beforeEach(function() {
    $this->projectRoot = TestFileSystem::projectRoot();
});

it('can get published content', function() {
   expect(
       count(
           TestFileSystem::init()->publishedContentFinder()
       )
   )->toBeInt()->toBe(6);
})->group('filesystem');

it('has required folders', function() {
    expect(
       TestFileSystem::init()->hasRequiredFolders()
    )->toBeTrue();

    expect(
       TestFileSystem::init()->contentRoot()
    )->toBe(
        $this->projectRoot . '/content'
    );

    expect(
       TestFileSystem::init()->publicRoot()
    )->toBe(
        $this->projectRoot . '/content/public'
    );
})->group('filesystem');
