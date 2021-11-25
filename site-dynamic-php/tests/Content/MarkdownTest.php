<?php

declare(strict_types=1);

use JoshBruce\SiteDynamic\Content\Markdown;

use JoshBruce\SiteDynamic\Environment;
use JoshBruce\SiteDynamic\FileSystem\PlainTextFile;

afterEach(function() {
    foreach ($_ENV as $var => $value) {
        if ($var !== 'SHELL_VERBOSITY') {
            unset($_ENV[$var]);
            unset($_SERVER[$var]);
        }
    }
});

test('converter is singleton', function() {
    $converter1 = Markdown::markdownConverter();
    $converter2 = Markdown::markdownConverter();

    expect(
        $converter1
    )->toBe(
        $converter2
    );
})->group('markdown');

it('can process log list partial', function() {
    $projectRoot = __DIR__ . '/../test-project-root';

    $file = PlainTextFile::at(
        $projectRoot . '/content/public/log-list/content.md',
        Environment::with($projectRoot)->publicRoot()
    );

    expect(
        Markdown::processPartials(<<<md
            {!! loglist !!}
            md,
            $file
        )
    )->toBe(<<<html
        <ul><li><a href="http://jbruce-test.com/log-list/alpha"></a></li><li><a href="http://jbruce-test.com/log-list/2021"></a></li><li><a href="http://jbruce-test.com/log-list/2020"></a></li></ul>
        html
    );
})->group('markdown', 'test-content', 'focus');

it('can process data partial', function() {
    $projectRoot = __DIR__ . '/../test-project-root';

    $file = PlainTextFile::at(
        $projectRoot . '/content/public/data/content.md',
        Environment::with($projectRoot)->publicRoot()
    );

    expect(
        Markdown::processPartials(<<<md
            {!! data !!}
            md,
            $file
        )
    )->toBe(<<<html
        <ul><li>Debt (decrease)<ul><li><b>current: </b>0.9</li><li><abbr title="minimum">min</abbr>: 0</li><li><abbr title="maximum">max</abbr>: 0</li></ul></li></ul>
        html
    );
})->group('markdown', 'test-content');

it('can process date block partial', function() {
    $projectRoot = __DIR__ . '/../../../';

    $file = PlainTextFile::at(
        $projectRoot . '/content/public/content.md',
        Environment::with($projectRoot)->publicRoot()
    );

    // preferred
    expect(
        Markdown::processPartials(<<<md
            {!! dateblock !!}
            md,
            $file
        )
    )->toBe(<<<html
        <div is="dateblock"><p>Created: <time content="2021-01-01" property="dateCreated">Jan 1, 2021</time></p></div>
        html
    );

    // legacy
    expect(
        Markdown::processPartials(<<<md
            {!!dateblock!!}
            md,
            $file
        )
    )->toBe(<<<html
        <div is="dateblock"><p>Created: <time content="2021-01-01" property="dateCreated">Jan 1, 2021</time></p></div>
        html
    );
})->group('markdown', 'live-content');
