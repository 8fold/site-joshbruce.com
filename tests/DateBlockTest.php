<?php

use JoshBruce\Site\PageComponents\DateBlock;
use JoshBruce\Site\PageComponents\Heading;
use JoshBruce\Site\PageComponents\Navigation;

use JoshBruce\Site\FileSystem;

beforeEach(function() {
    // This somewhat unreadable one-liner basically creates a fully qualified
    // path to the root of the project, without using relative syntax
    $this->projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

    $this->contentRoot = $this->projectRoot . '/tests/test-content';

    $this->fileSystem = FileSystem::init(
        contentRoot: $this->contentRoot,
        folderPath: '/tests/test-content'
    );
});

test('navigation', function() {
    expect(
        Navigation::create($this->fileSystem)->build()
    )->toBe(<<<html
        <nav id="main-nav"><ul><li><a href="/">home</a></li><li><a href="/finances">Finances</a><ul><li><a href="/finances/investment-policy">Investment policy</a></li><li><a href="/finances/building-wealth-paycheck-to-paycheck">Paycheck to paycheck</a></li></ul></li><li><a href="/design-your-life">Design your life</a><ul><li><a href="/design-your-life/motivators">Motivators</a></li></ul></li><li><a href="/software-development">Software development</a><ul><li><a href="/software-development/why-dont-you-use">Why don't you use</a></li><li><a href="/somethig-with-commas">Some, commas, and whatnot</a></li></ul></li></ul></nav>
        html
    );
});

test('heading', function() {
    expect(
        Heading::create(['title' => 'Hello, World!'])
    )->toBe(<<<md
        # Hello, World!
        md
    );
});

test('dateblock', function() {
   expect(
       DateBlock::create(['created' => '20210101'])
   )->toBe(<<<html
       <div is="dateblock"><p>Created on: <time content="2021-01-01" property="dateCreated">Jan 1, 2021</time></p></div>
       html
   );

    expect(
       DateBlock::create(['updated' => '20210101'])
    )->toBe(<<<html
       <div is="dateblock"><p>Updated on: <time content="2021-01-01" property="dateModified">Jan 1, 2021</time></p></div>
       html
    );

    expect(
       DateBlock::create([
           'created' => '20210110',
           'updated' => '20210101'
       ])
    )->toBe(<<<html
       <div is="dateblock"><p>Created on: <time content="2021-01-10" property="dateCreated">Jan 10, 2021</time></p><p>Updated on: <time content="2021-01-01" property="dateModified">Jan 1, 2021</time></p></div>
       html
    );

})->group('components');
