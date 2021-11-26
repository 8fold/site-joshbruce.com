<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

beforeEach(function() {
    $this->publicRoot = __DIR__ . '/../test-project-root/content/public';
    $this->publish2Content = $this->publicRoot .
        '/published/published-2/content.md';
});

it('can get page and social titles', function() {
    expect(
        PlainTextFile::at(
            $this->publish2Content,
            $this->publicRoot
        )->pageTitle()
    )->toBeString()->toBe(
        'Published content 2 | Published content | Test content home'
    );

    expect(
        PlainTextFile::at(
            $this->publish2Content,
            $this->publicRoot
        )->socialTitle()
    )->toBeString()->toBe(
        'Published content 2 | Test content home'
    );
})->group('plain-text-file', 'test-content');

it('can get title', function() {
    expect(
        PlainTextFile::at(
            $this->publish2Content,
            $this->publicRoot
        )->title()
    )->toBeString()->toBe(
        'Published content 2'
    );
})->group('plain-text-file', 'test-content');
