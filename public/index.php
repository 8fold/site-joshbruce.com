<?php
require __DIR__ . '/../vendor/autoload.php';

/**
 * Rergardless of what happens next, we'll need a basline markown converter.
 *
 * We only want the bare minimum setup in the beginning.
 */
$markdownConverter = Eightfold\Markdown\Markdown::create()
                ->minified()
                ->smartPunctuation();

// Inject environment variables to global $_SERVER array
Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

$projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

/**
 * Verifying setup is valid.
 */
$requestRequiredServerGlobals = [
    'APP_ENV',
    'CONTENT_UP',
    'CONTENT_FOLDER'
];

// TESTING
// unset($_SERVER['APP_ENV']);
$requestHasRequiredServerGlobals = true;
foreach ($requestRequiredServerGlobals as $key) {
    if (! array_key_exists($key, $_SERVER)) {
        $requestHasRequiredServerGlobals = false;
        break;
    }
}

if (! $requestHasRequiredServerGlobals) {
    $content = JoshBruce\Site\Content::init($projectRoot, 0, '/500-errors')
        ->for('/500.md');

    JoshBruce\Site\Emitter::emitWithResponse(
        500,
        [
            'Cache-Control' => [
                'no-cache',
                'must-revalidate'
            ]
        ],
        Eightfold\HTMLBuilder\Document::create(
                $markdownConverter->getFrontMatter($content->markdown())['title']
            )->body(
                $markdownConverter->convert($content->markdown())
            )->build()
    );
    exit;
}

/**
 * Verifying specified content area exists.
 */

// TESTING
// $_SERVER['CONTENT_FOLDER'] = '/does/not/exist';
$content = JoshBruce\Site\Content::init(
    $projectRoot,
    $_SERVER['CONTENT_UP'],
    $_SERVER['CONTENT_FOLDER']
);

if (! $content->isValid()) {
    $content = JoshBruce\Site\Content::init($projectRoot, 0, '/500-errors')
        ->for('/502.md');

    JoshBruce\Site\Emitter::emitWithResponse(
        502,
        [
            'Cache-Control' => [
                'no-cache',
                'must-revalidate'
            ]
        ],
        Eightfold\HTMLBuilder\Document::create(
                $markdownConverter->getFrontMatter($content->markdown())['title']
            )->body(
                $markdownConverter->convert($content->markdown())
            )->build()
    );
    exit;
}

/**
 * Bootsrap is complete: local response time 19ms
 *
 * Does the requested content exist?
 */
$requestUri = $_SERVER['REQUEST_URI'];
if ($requestUri === '/') {
    $requestUri = '';
}

// TESTING
// $requestUri = '/does/not/exist'; // 404
// $requestUri = '/assets/favicons/favicon-16x16.png'; // file

$requestIsForFile = strpos($requestUri, '.') > 0;

$localFilePath = $requestUri . '/content.md';
if ($requestIsForFile) {
    $folderMap = [
        '/css'    => '/.assets/styles',
        '/js'     => '/.assets/scripts',
        '/assets' => '/.assets'
    ];

    $parts   = explode('/', $requestUri);
    $parts   = array_filter($parts);
    $first   = array_shift($parts);
    $search  = '/' . $first;

    if (array_key_exists($search, $folderMap)) {
        $replace = $folderMap[$search];

        $localFilePath = str_replace($search, $replace, $requestUri);
    }
}

$content = $content->for($localFilePath);
if ($content->notFound()) {
    $content = $content->for(path: '/.errors/404.md');
    JoshBruce\Site\Emitter::emitWithResponse(
        404,
        [
            'Cache-Control' => [
                'no-cache',
                'must-revalidate'
            ]
        ],
        Eightfold\HTMLBuilder\Document::create(
                $content->title()
            )->body(
                $content->html()
            )->build()
    );
    exit;
}

/**
 * Target file exists: local response time 27ms
 *
 * Handle file
 */
if ($requestIsForFile) {
    JoshBruce\Site\Emitter::emitWithResponseFile(
        200,
        [
            'Cache-Control' => ['max-age=2592000'],
            'Content-Type'  => $content->mimeType()
        ],
        $content->filePath()
    );
    exit;
}
die(var_dump($requestHasRequiredServerGlobals));

$server = JoshBruce\Site\Server::init($_SERVER);

/**
 * We'll probably replace with the middleware pattern from PSR-7.
 *
 * 1. Check .env file has the required members; 500 response on failure.
 * 2. Check the content folder can be accessed; 502 response on failure.
 * 3. Start the app and determine response.
 */
$response = $server->response();
if ($response->isOk() and $env = JoshBruce\Site\Environment::init($server)) {
    // server global set up correctly - start environment
    $response = $env->response();
    if ($response->isOk() and $app = JoshBruce\Site\App::init($env)) {
        // environment can connect to content - start app
        $response = $app->response();
    }
}

$response->emit();

exit;
