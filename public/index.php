<?php

declare(strict_types=1);

$projectRoot = implode('/', array_slice(explode('/', __DIR__), 0, -1));

require $projectRoot . '/vendor/autoload.php';

// Inject environment variables to global $_SERVER array
Dotenv\Dotenv::createImmutable($projectRoot)->load();

// $server = JoshBruce\Site\SiteDynamic\Server::init($_SERVER, $projectRoot);
JoshBruce\Site\SiteDynamic\Emitter::emit(
    response:JoshBruce\Site\HttpResponse::from(
        request: JoshBruce\Site\HttpRequest::fromGlobals()
    )
);
exit;
// die(var_dump($response));
// if ($request->isMissingRequiredValues()) {
//     JoshBruce\Site\SiteDynamic\Emitter::emitInteralServerErrorResponse(
//         JoshBruce\Site\Content\Markdown::markdownConverter(),
//         $projectRoot
//     );
//     exit;
// }
//
// if ($request->isUnsupportedMethod()) {
//     JoshBruce\Site\SiteDynamic\Emitter::emitUnsupportedMethodResponse(
//         JoshBruce\Site\Content\Markdown::markdownConverter(),
//         $projectRoot,
//         $server
//     );
//     exit;
// }
//
// // $fileSystem = JoshBruce\Site\FileSystem::init(
// //     $server->contentRoot(),
// //     $server->requestUriWithoutFileName(),
// //     $server->requestFileName()
// // );
//
// // if ($fileSystem->rootFolderIsMissing()) {
// //     JoshBruce\Site\SiteDynamic\Emitter::emitBadContentResponse(
// //         JoshBruce\Site\Content\Markdown::markdownConverter(),
// //         $projectRoot
// //     );
// //     exit;
// // }
//
// // TESTING: Redirection
// // Check browser address becomes /design-your-life
// // if ($server->requestUriWithoutFileName() !== '/design-your-life') {
// //     $_SERVER['REQUEST_URI'] = '/self-improvement';
// //     $server = JoshBruce\Site\Server::init($_SERVER, $projectRoot);
// // }
//
// $fileSystem = $fileSystem->with(
//     folderPath: $server->requestUriWithoutFileName(),
//     fileName: $server->requestFileName()
// );
//
// if ($fileSystem->notFound()) {
//     $fileSystem = $fileSystem->with('/', 'error-404.md');
//     JoshBruce\Site\SiteDynamic\Emitter::emitNotFoundResponse(
//         JoshBruce\Site\Content\Markdown::markdownConverter(),
//         $fileSystem
//     );
//     exit;
// }
//
// if ($server->isRequestingFile()) {
//     JoshBruce\Site\SiteDynamic\Emitter::emitFile(
//         $fileSystem->mimeType(),
//         $fileSystem->path()
//     );
//     exit;
// }
//
// $markdown = JoshBruce\Site\Content\Markdown::init($fileSystem);
// if ($markdown->hasMoved()) {
//     $location = $server->domain() . $markdown->redirectPath();
//     JoshBruce\Site\SiteDynamic\Emitter::emitRedirectionResponse($location);
//     exit;
// }
//
// $page = JoshBruce\Site\Pages\DefaultTemplate::create(
//     JoshBruce\Site\Content\Markdown::init($fileSystem)->convert(),
//     $fileSystem->mimeType(),
//     $fileSystem->folderStack(),
//     $fileSystem->contentRoot()
// );
//
// JoshBruce\Site\SiteDynamic\Emitter::emitWithResponse(
//     200,
//     $page->headers(),
//     $page->body()
// );
// exit;
