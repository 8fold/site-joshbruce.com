<?php
//
// use JoshBruce\Site\SiteStatic\Generator;
//
// use JoshBruce\Site\Tests\StaticGenerator\OutputInterface;
//
// beforeEach(function() {
//     $this->projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -2));
//
//     $this->contentRoot = $this->projectRoot . '/tests/test-content/content';
//
//     $this->destination = $this->projectRoot . '/tests/compiled/content';
//
//     $_SERVER['APP_ENV'] = 'testing';
// });
//
// it('can instantiate generator', function() {
//     expect(
//         new Generator(
//             new OutputInterface(),
//             $this->contentRoot,
//             $this->destination
//         )
//     )->toBeInstanceOf(
//         Generator::class
//     );
// })->group('static');
//
// it('can create output interface instance', function() {
//     expect(
//         new OutputInterface()
//     )->toBeInstanceOf(
//         OutputInterface::class
//     );
// })->group('static');
