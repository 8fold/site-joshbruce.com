<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\Environment;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

afterEach(function () {
    foreach ($_ENV as $var => $value) {
        if ($var !== 'SHELL_VERBOSITY') {
            unset($_ENV[$var]);
            unset($_SERVER[$var]);
        }
    }
});

// @phpstan-ignore-next-line
test('converter is singleton', function () {
    $converter1 = Markdown::markdownConverter();
    $converter2 = Markdown::markdownConverter();

    expect(
        $converter1
    )->toBe(
        $converter2
    );
})->group('markdown');

it('can process original partial', function () {
    $projectRoot = __DIR__ . '/../test-project-root';

    $file = PlainTextFile::at(
        $projectRoot . '/content/public/original/content.md',
        Environment::with($projectRoot)->publicRoot()
    );

    expect(
        Markdown::processPartials(
            <<<md
            {!! original !!}
            md,
            $file
        ) . "\n"
    )->toBe(
        file_get_contents(__DIR__ . '/partial-output-original.html')
    );
})->group('markdown', 'test-content');

it('can process log list partial', function () {
    $projectRoot = __DIR__ . '/../test-project-root';

    $file = PlainTextFile::at(
        $projectRoot . '/content/public/log-list/content.md',
        Environment::with($projectRoot)->publicRoot()
    );

    expect(
        Markdown::processPartials(
            <<<md
            {!! loglist !!}
            md,
            $file
        ) . "\n"
    )->toBe(
        file_get_contents(__DIR__ . '/partial-output-log-list.html')
    );
})->group('markdown', 'test-content');

it('can process data partial', function () {
    $projectRoot = __DIR__ . '/../test-project-root';

    $file = PlainTextFile::at(
        $projectRoot . '/content/public/data/content.md',
        Environment::with($projectRoot)->publicRoot()
    );

    expect(
        Markdown::processPartials(
            <<<md
            {!! data !!}
            md,
            $file
        ) . "\n"
    )->toBe(
        file_get_contents(__DIR__ . '/partial-output-data.html')
    );
})->group('markdown', 'test-content');

it('can process date block partial', function () {
    $projectRoot = __DIR__ . '/../../../';

    $file = PlainTextFile::at(
        $projectRoot . '/content/public/content.md',
        Environment::with($projectRoot)->publicRoot()
    );

    // preferred
    expect(
        Markdown::processPartials(
            <<<md
            {!! dateblock !!}
            md,
            $file
        ) . "\n"
    )->toBe(
        file_get_contents(__DIR__ . '/partial-output-date-block.html')
    );

    // legacy
    expect(
        Markdown::processPartials(
            <<<md
            {!!dateblock!!}
            md,
            $file
        ) . "\n"
    )->toBe(
        file_get_contents(__DIR__ . '/partial-output-date-block.html')
    );
})->group('markdown', 'live-content');
