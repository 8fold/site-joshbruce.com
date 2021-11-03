<?php

use JoshBruce\Site\PageComponents\DateBlock;
use JoshBruce\Site\PageComponents\Heading;

use JoshBruce\Site\Content\FrontMatter;

test('heading', function() {
    expect(
        Heading::create(
            FrontMatter::init(['title' => 'Hello, World!'])
        )
    )->toBe(<<<md
        # Hello, World!
        md
    );
});

test('dateblock', function() {
   expect(
       DateBlock::create(
           FrontMatter::init(['created' => '20210101'])
       )
   )->toBe(<<<html
       <div is="dateblock"><p>Created on: <time content="2021-01-01" property="dateCreated">Jan 1, 2021</time></p></div>
       html
   );

    expect(
       DateBlock::create(
           FrontMatter::init(['updated' => '20210101'])
       )
    )->toBe(<<<html
       <div is="dateblock"><p>Updated on: <time content="2021-01-01" property="dateModified">Jan 1, 2021</time></p></div>
       html
    );

    expect(
       DateBlock::create(
           FrontMatter::init([
               'created' => '20210110',
               'updated' => '20210101'
           ])
       )
    )->toBe(<<<html
       <div is="dateblock"><p>Created on: <time content="2021-01-10" property="dateCreated">Jan 10, 2021</time></p><p>Updated on: <time content="2021-01-01" property="dateModified">Jan 1, 2021</time></p></div>
       html
    );

})->group('components');
