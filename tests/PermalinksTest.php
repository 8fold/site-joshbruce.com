<?php

/**
 * This test suite confirms the site-permalink-ids/links.txt file has the
 * correct number of entries and validates the target URLs.
 *
 * In other words, since we're maintaining those manually right now, we want
 * to make sure they're correct.
 *
 * The naming convention will be to use the last part of the URI in full,
 * any names leading up to the last part will use the first letter for each
 * word. For example:
 *     - /web-development/on-constraints/internet-bandwidth becomes
 *     - /wd-oc-internet-bandwidth
 *
 * Even if the URI changes, the permalink id shouldn't.
 *
 * @todo: php amos compile:permalinks
 */

use JoshBruce\Site\FileSystem;
use JoshBruce\Site\File;

use JoshBruce\Site\Documents\AtomFeed;

test('Finder count and items in links.txt match', function() {
    $localPath = FileSystem::init()->publicRoot() . '/links.txt';
    $file = File::at($localPath, FileSystem::init());

    expect($file->found())->toBeTrue();

    $links = array_filter(explode("\n", $file->contents()));

    expect(
        count(
            AtomFeed::finder(FileSystem::init()
            )
        )
    )->toBe(
        count($links)
    );
})->group('permalinks', 'focus');
