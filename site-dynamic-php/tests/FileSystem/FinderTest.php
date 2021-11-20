<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\FileSystem\Finder;

use JoshBruce\SiteDynamic\Tests\Extensions\FileSystem\Finder as TestFinder;

test('can instantiate live version', function() {
   expect(
       Finder::init()
   )->toBeInstanceOf(
       Finder::class
   );
})->group('finder');

test('live content has expected folders', function() {
   expect(
       Finder::init()->hasRequiredFolders()
   )->toBeTrue();
})->group('finder', 'live-content');

test('live content has expected published count', function() {
   $expected = 42;

   expect(
       count(Finder::init())
   )->toBe($expected);

   expect(
       Finder::init()->count()
   )->toBe($expected);
})->group('finder', 'live-content');

test('live content has expected draft count', function() {
   $expected = 9;

   expect(
       count(Finder::init()->draftContent())
   )->toBe($expected);

   expect(
       Finder::init()->draftContent()->count()
   )->toBe($expected);
})->group('finder', 'live-content');

test('live content has expected redirected count', function() {
   $expected = 4;

   expect(
       count(Finder::init()->redirectedContent())
   )->toBe($expected);

   expect(
       Finder::init()->redirectedContent()->count()
   )->toBe($expected);
})->group('finder', 'live-content');

test('can instantiate test version', function() {
   expect(
       TestFinder::init()
   )->toBeInstanceOf(
       TestFinder::class
   );
})->group('finder');

test('test content has expected published count', function() {
    $expected = 2;

    expect(
       count(TestFinder::init())
    )->toBe($expected);

    expect(
       TestFinder::init()->publishedContent()->count()
    )->toBe($expected);
})->group('finder', 'test-content');

test('test content has expected draft count', function() {
   $expected = 1;

   expect(
       count(TestFinder::init()->draftContent())
   )->toBe($expected);

   expect(
       TestFinder::init()->draftContent()->count()
   )->toBe($expected);
})->group('finder', 'test-content');

test('test content has expected redirected count', function() {
   $expected = 1;

   expect(
       count(TestFinder::init()->redirectedContent())
   )->toBe($expected);

   expect(
       TestFinder::init()->redirectedContent()->count()
   )->toBe($expected);
})->group('finder', 'redirect-content');

test('test content has expected folders', function() {
   expect(
       TestFinder::init()->hasRequiredFolders()
   )->toBeTrue();
})->group('finder', 'test-content');
