<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

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

/** Partials **/
use JoshBruce\Site\Partials\DateBlock;
use JoshBruce\Site\Partials\NextPrevious;
use JoshBruce\Site\Partials\ArticleList;
use JoshBruce\Site\Partials\PaycheckLogList;
use JoshBruce\Site\Partials\OriginalContentNotice;
use JoshBruce\Site\Partials\Data;
use JoshBruce\Site\Partials\FiExperiments;
use JoshBruce\Site\Partials\FullNav;
use JoshBruce\Site\Partials\HealthLogList;

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
    ->abbreviations()
    ->partials([
        'partials' => [
            'dateblock'        => DateBlock::class,
            'next-previous'    => NextPrevious::class,
            'article-list'     => ArticleList::class,
            'paycheck-loglist' => PaycheckLogList::class,
            'original'         => OriginalContentNotice::class,
            'data'             => Data::class,
            'fi-experiments'   => FiExperiments::class,
            'full-nav'         => FullNav::class,
            'health-loglist'   => HealthLogList::class
        ],
        'extras' => [
            'meta'         => $site->publicMeta($path),
            'site'         => $site,
            'request_path' => $path
        ]
    ]);

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
