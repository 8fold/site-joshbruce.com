<?php
declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
// error_reporting(E_ALL);

ini_set('realpath_cache_size', '4096');
ini_set('realpath_cache_ttl', '600');

require __DIR__ . '/../../vendor/autoload.php';

use Nyholm\Psr7Server\ServerRequestCreator;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;

use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

use Eightfold\Markdown\Markdown;

use Eightfold\Amos\Site;
use Eightfold\Amos\Http\Root as HttpRoot;
use Eightfold\Amos\FileSystem\Directories\Root as ContentRoot;

use JoshBruce\Site\Documents\Sitemap;

use JoshBruce\Site\Templates\Page;
use JoshBruce\Site\Templates\PageNotFound;

$emitter = new SapiEmitter();

$psr17Factory = new Psr17Factory();

$request = (new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
))->fromGlobals();

$uri = $request->getUri();

$site = Site::init(
    ContentRoot::fromString(__DIR__ . '/../../content-root'),
    HttpRoot::fromString($uri->getScheme() . '://' . $uri->getAuthority())
);

if ($site === false) {
    $error500 = file_get_contents(__DIR__ . '/error-500.html');
    if ($error500 === false) {
        $error500 = 'Server error.';
    }

    $response = new Response(
        500,
        body: $error500
    );

    $emitter->emit($response);
    exit();
}

$path = $uri->getPath();

if (str_ends_with($path, 'sitemap.xml')) {
    $response = new Sitemap();

    $emitter->emit($response($site));
    exit();
}

$converter = Markdown::create()
    ->withConfig([
        'html_input' => 'allow'
    ])->defaultAttributes([
        Image::class => [
            'loading'  => 'lazy',
            'decoding' => 'async'
        ]
    ])->externalLinks([
        'open_in_new_window' => true,
        'internal_hosts'     => $site->domain()->toString()
    ])->accessibleHeadingPermalinks([
        'min_heading_level' => 2,
        'max_heading_level' => 3,
        'symbol'            => '＃'
    ])->minified()
    ->smartPunctuation()
    ->descriptionLists()
    ->tables()
    ->attributes() // for class on notices
    ->abbreviations();

if ($site->hasPublicMeta($path) === false) {
    $response = new Response(
        404,
        body: (string) PageNotFound::create($site)
            ->withConverter($converter)->withRequestPath($path)
    );

    $emitter->emit($response);
    exit();
}

$body = (string) Page::create($site)
    ->withConverter($converter)
    ->withRequestPath($path);

$response = new Response(200, body: $body);

$emitter->emit($response);
exit();
