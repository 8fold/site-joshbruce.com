<?php

use JoshBruce\Site\ServerGlobals;

use JoshBruce\Site\FileSystem;

use Symfony\Component\Finder\Finder;

test('only ServerGlobals references $_SERVER', function() {
    $finder = new Finder();
    $found  = $finder->ignoreVCS(false)->files()->name('*.php')->in(
        FileSystem::projectRoot() . '/src'
    )->contains('$_SERVER');

    foreach ($found as $f) {
        $result = str_ends_with($f->getPathname(), 'ServerGlobals.php');
        if (! $result){
            var_dump($f->getPathname());
        }
        $this->assertTrue($result);
    }
})->group('server-globals', 'focus');
