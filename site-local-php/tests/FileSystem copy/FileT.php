<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\Tests;

use JoshBruce\SiteDynamic\Tests\LiveContentTestCase;

final class IndexTest extends LiveContentTestCase
{
    /**
     * @test
     *
     * @group live-content
     */
    public function index_exists(): void
    {
        $this->assertIsString(self::pathToIndex());
    }
}

test('can be instantiated', function () {
    expect(
        File::at(
            __DIR__ . '/../test-project-root/content/public/content.md',
            __DIR__ . '/../test-project-root/content/public'
        )->mimetype()->name()
    )->toBe('html');

    expect(
        File::from(
            new \SplFileInfo(
                __DIR__ . '/../test-project-root/content/public/content.md'
            ),
            __DIR__ . '/../test-project-root/content/public'
        )->mimetype()->name()
    )->toBe('html');
})->group('file', 'test-content');
