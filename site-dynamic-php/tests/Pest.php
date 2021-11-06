<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

// use JoshBruce\Site\Environment;
use JoshBruce\DynamicSite\Server;

// function environment(string $requestUri = '/'): Environment
// {
//     return Environment::init(server($requestUri));
// }

// function server(string $requestUri = '/'): Server
// {
//     return Server::init(serverGlobals($requestUri));
// }

/**
 * @return array<string, int|string>
 */
function serverGlobals(string $requestUri = '/'): array
{
    $_SERVER['APP_ENV']        = 'test';
    $_SERVER['CONTENT_UP']     = 0;
    $_SERVER['CONTENT_FOLDER'] = '/tests/test-content/content';
    $_SERVER['REQUEST_SCHEME'] = 'http';
    $_SERVER['HTTP_HOST']      = 'testing.com';
    $_SERVER['REQUEST_URI']    = $requestUri;
    $_SERVER['REQUEST_METHOD'] = 'get';

    return $_SERVER;
}
