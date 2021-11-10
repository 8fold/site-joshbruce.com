<?php

use JoshBruce\Site\ServerGlobals;

use JoshBruce\Site\FileSystem;

use Symfony\Component\Finder\Finder;

it('has required values', function() {
    expect(
        ServerGlobals::init()->withRequestUri('/something')->requestUri()
    )->toBe(
        '/something'
    );

    expect(
        ServerGlobals::init()->withRequestMethod('GET')->requestMethod()
    )->toBe(
        'GET'
    );

    expect(
        ServerGlobals::init()->withRequestMethod('POST')->requestMethod()
    )->toBe(
        'POST'
    );

    expect(
        ServerGlobals::init()->isMissingRequiredValues()
    )->toBeFalse();
})->group('server-globals');

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
})->group('server-globals');
