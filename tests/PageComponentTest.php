<?php
//
// use JoshBruce\Site\PageComponents\DateBlock;
// use JoshBruce\Site\PageComponents\Heading;
// use JoshBruce\Site\PageComponents\Navigation;
//
// use JoshBruce\Site\FileSystem;
//
// // beforeEach(function() {
// //     // This somewhat unreadable one-liner basically creates a fully qualified
// //     // path to the root of the project, without using relative syntax
// //     $this->projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));
// //
// //     serverGlobals();
// //
// //     $this->contentRoot = $this->projectRoot . $_SERVER['CONTENT_FOLDER'];
// //
// //     $this->fileSystem = FileSystem::init($this->contentRoot);
// // });
//
// test('navigation', function() {
//     expect(
//         Navigation::create('main.md')->build()
//     )->toBe(<<<html
//         <nav id="main-nav"><ul><li><a href="/">Josh Bruce</a></li><li><a href="/finances">Finances</a><ul><li><a href="/finances/investment-policy">Investment policy</a></li><li><a href="/finances/building-wealth-paycheck-to-paycheck">Paycheck to paycheck</a></li></ul></li><li><a href="/design-your-life">Design your life</a><ul><li><a href="/design-your-life/motivators">Motivators</a></li></ul></li><li><a href="/software-development">Software development</a><ul><li><a href="/software-development/why-dont-you-use">Why donʼt you use</a></li></ul></li><li><a href="/web-development">Web development</a><ul><li><a href="/web-development/on-constraints">On constraints</a></li><li><a href="/web-development/modern-web-development">Modern web development</a></li><li><a href="/web-development/static-dynamic-and-interactive">Static, dynamic, and interactive</a></li><li><a href="/web-development/refactoring-re-engineering-and-rebuilding">Refactoring, re-engineering, and rebuilding</a></li></ul></li></ul></nav>
//         html
//     );
// })->group('components', 'navigation');
//
// use JoshBruce\Site\Content\FrontMatter;
//
// test('heading', function() {
//     expect(
//         Heading::create(
//             FrontMatter::init(['title' => 'Hello, World!'])
//         )
//     )->toBe(<<<md
//         # Hello, World!
//         md
//     );
// });
//
// test('dateblock', function() {
//    expect(
//        DateBlock::create(
//            FrontMatter::init(['created' => '20210101'])
//        )
//    )->toBe(<<<html
//        <div is="dateblock"><p>Created on: <time content="2021-01-01" property="dateCreated">Jan 1, 2021</time></p></div>
//        html
//    );
//
//     expect(
//        DateBlock::create(
//            FrontMatter::init(['updated' => '20210101'])
//        )
//     )->toBe(<<<html
//        <div is="dateblock"><p>Updated on: <time content="2021-01-01" property="dateModified">Jan 1, 2021</time></p></div>
//        html
//     );
//
//     expect(
//        DateBlock::create(
//            FrontMatter::init([
//                'created' => '20210110',
//                'updated' => '20210101'
//            ])
//        )
//     )->toBe(<<<html
//        <div is="dateblock"><p>Created on: <time content="2021-01-10" property="dateCreated">Jan 10, 2021</time></p><p>Updated on: <time content="2021-01-01" property="dateModified">Jan 1, 2021</time></p></div>
//        html
//     );
//
// })->group('components');
