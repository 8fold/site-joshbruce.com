<?php

declare(strict_types=1);

// @phpstan-ignore-next-line
test('index is not displaying errors', function () {
    $rPath = __DIR__ . '/../../site-dynamic-php/public/index.php';
    $file  = new SplFileInfo($rPath);
    $path  = $file->getRealPath();

    if (
        is_string($path) and
        $contents = file_get_contents($path) and
        is_string($contents)
    ) {
        $matches = [];
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

    } else {
        // @phpstan-ignore-next-line
        $this->assertTrue(false, 'Either the path or contents is false');

    }
})->group('index');
