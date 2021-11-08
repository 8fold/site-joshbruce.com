<?php

declare(strict_types=1);

test('index is not displaying errors', function() {
    $dir     = __DIR__;
    $parts   = explode('/', $dir);
    $parts   = array_slice($parts, 0, -1);
    $parts[] = 'public';
    $parts[] = 'index.php';

    $path = implode('/', $parts);

    expect(is_file($path))->toBeTrue();

    $contents = file_get_contents($path);

    preg_match_all('/ini_set\(.*\);/', $contents, $matches);
    $matches = array_shift($matches);

    expect(count($matches))->toBeGreaterThan(0);

    foreach ($matches as $match) {
        expect(
            str_contains($match, '1'),
            'Okay to fail in local.'
        )->toBeFalse();
    }
})->group('index', 'focus');
