<?php

declare(strict_types=1);

test('index is not displaying errors', function() {
    // TODO: refactor
    $dir     = __DIR__;
    $parts   = explode('/', $dir);
    $parts   = array_slice($parts, 0, -2);
    $parts[] = 'site-dynamic-php';
    $parts[] = 'public';
    $parts[] = 'index.php';

    $path = implode('/', $parts);

    // index.php should exist
    expect(is_file($path))->toBeTrue();

    $contents = file_get_contents($path);

    preg_match_all('/ini_set\(.*\);/', $contents, $matches);
    $matches = array_shift($matches);

    // ini_set should be present
    expect(count($matches))->toBe(2);

    // ini_set should be 0
    foreach ($matches as $match) {
        expect(
            str_contains($match, '1'),
            'Okay to fail in local.'
        )->toBeFalse();
    }
})->group('index');
