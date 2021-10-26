<?php

use JoshBruce\Site\Content;

beforeEach(function() {
    // This somewhat unreadable one-liner basically creates a fully qualified
    // path to the root of the project, without using relative syntax
    $projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

    $this->baseContent = Content::init(
        projectRoot: $projectRoot,
        contentUp: 0,
        contentFolder: '/tests/test-content'
    );
});

it('has correct mimetypes', function() {
    expect($this->baseContent->isValid())->toBeTrue();
})->group('content');
