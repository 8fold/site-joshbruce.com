<?php

declare(strict_types=1);

namespace JoshBruce\Site;

// use Eightfold\HTMLBuilder\Document as HtmlDocument;
// use Eightfold\HTMLBuilder\Element as HtmlElement;

use Eightfold\Amos\Store;
// use Eightfold\Amos\Markdown;
// use Eightfold\Amos\PageComponents\PageTitle;

// use JoshBruce\Site\PageComponents\Head;

use JoshBruce\Site\Http\Uri;
use JoshBruce\Site\Http\Request;
use JoshBruce\Site\Http\Response;

class App
{
    /**
     * @var Store
     */
    private $store;

    private string $protocol = 'HTTP/2';

    /**
     * @var string[]
     */
    private array $responseMessages = [
        200 => 'OK',
        404 => 'Not Found'
    ];

    public static function runFromServerGlobal()
    {
        return App::create($_SERVER);
    }

    /**
     * In a server environment, `$serverGlobal` would be the entire $_SERVER
     * array in PHP, which is not available in a non-server environment (like
     * the CLI tools for automated tests and this functionality isn't needed
     * at this time in order test the capabilities of this class).
     *
     * @param array<string|int|float> $serverGlobal
     */
    public static function run(array $serverGlobal): App
    {
        return new App($serverGlobal);
    }

    /**
     * @param array<string|int|float> $serverGlobal
     */
    public function __construct(
        private array $serverGlobal
    ) {
    }

    public function response(): Response
    {
        // Implementing this is jumping the gun as we are only responding to
        // get requests at this time.
        //
        // $method = 'GET';
        // if (array_key_exists('REQUEST_METHOD', $this->serverGlobal())) {
        //     $sg = $this->serverGlobal();
        //     $method = $sg['REQUEST_METHOD'];
        // }

        $request = Request::create(
            'get',
            Uri::create($this->serverGlobal())
        );

        return Response::create($request, $this->store());
    }

    private function serverGlobal(): array
    {
        return $this->serverGlobal;
    }

    private function store(): Store
    {
        if ($this->store === null) {
            $this->store = Store::create($this->contentPath());
        }
        return $this->store;
    }










    public function emit(): void
    {
        if ($this->isAsset()) {
            $this->emitAsset();
        }
        $this->emitHeader();
        $this->emitHtml();
    }

    private function isAsset(): bool
    {
        $parts = explode('/', $this->requestUri());
        $parts = array_filter($parts);
        return array_shift($parts) === 'assets';
    }

    private function emitHtml(): void
    {
        $content = $this->store()->markdown('content.md');

        if (is_bool($content) and ! $content) {
            print $this->errorPage();
        }

        if (is_object($content)) {
            print HtmlDocument::create(
                PageTitle::create($this->store())->build()
            )->head(
                ...Head::create(
                    $this->store(),
                    PageTitle::create($this->store())->buildBookend(),
                    $this->requestUriFull()
                )
            )->body(
                $content->html()
            );
        }
        print '';
    }

    private function emitAsset(): void
    {

    }

    /**
     * Set from .env
     *
     * Only necessary if configuration will be public and you'd like to keep it
     * relatively secret.
     */
    private function contentUp(): int
    {
        return intval($this->serverGlobal['CONTENT_UP']);
    }

    /**
     * Set from .env
     *
     * Only necessary if configuration will be public and you'd like to keep it
     * relatively secret.
     */
    private function contentFolder(): string
    {
        $value = $this->serverGlobal['CONTENT_FOLDER'];
        if (is_string($value)) {
            return $value;
        }
        return '';
    }

    // private function requestMethod(): string
    // {
    //     $value = $this->serverGlobal['REQUEST_METHOD'];
    //     if (is_string($value)) {
    //         return strtolower($value);
    //     }
    //     return '';
    // }

    // private function requestUri(): string
    // {
    //     $value = $this->serverGlobal['REQUEST_URI'];
    //     if (is_string($value)) {
    //         return $value;
    //     }
    //     return '';
    // }

    // private function requestUriFull(): string
    // {
    //     $scheme  = $this->serverGlobal['REQUEST_SCHEME'];
    //     $host    = $this->serverGlobal['HTTP_HOST'];
    //     $path    = $this->requestUri();

    //     return $scheme . '://' . $host . $path;
    // }

    private function contentPath(): string
    {
        $dir   = __DIR__;
        $parts = explode('/', $dir);
        // content folder shouldn't be inside project folder
        $parts = array_slice($parts, 0, -2);
        // number of directories to go up outsde project directory
        $up    = $this->contentUp();
        if ($up > 0) {
            $parts = array_slice($parts, 0, -1 * intval($up));
        }

        // name of the folder storing the content
        $parts[] = $this->contentFolder();

        return implode('/', $parts);
    }

    // private function path(): string
    // {
    //     if (strtolower($this->requestMethod()) !== 'get') {
    //         return '';
    //     }
    //     return $this->requestUri();
    // }



    private function protocol(): string
    {
        return $this->protocol;
    }

    private function responseCode(): int
    {
        if ($this->store()->hasFile('content.md')) {
            return 200;
        }
        return 404;
    }

    private function responseMessage(): string
    {
        return $this->responseMessages[$this->responseCode()];
    }

    private function emitHeader(): void
    {
        $header = [
            $this->protocol(),
            $this->responseCode(),
            $this->responseMessage()
        ];

        header(implode(' ', $header), true, $this->responseCode());
        header('cache-control: no-cache, private', false);
    }

    private function errorPage(): string
    {
        $errorContent = Store::create($this->contentPath())
            ->append('.errors')->markdown('404.md');

        $rootContent = Store::create($this->contentPath())
            ->markdown('content.md');

        if (is_object($errorContent) and is_object($rootContent)) {
            return (string) HtmlDocument::create(
                $errorContent->title() . ' | ' . $rootContent->title()
            )->body(
                $errorContent->html()
            );
        }
        return '';
    }

    // public function response(): void
    // {
        // $this->emitHeader();

        // $content = $this->store()->markdown('content.md');

        // if (is_bool($content) and ! $content) {
        //     print $this->errorPage();
        // }

        // if (is_object($content)) {
        //     print HtmlDocument::create(
        //         PageTitle::create($this->store())->build()
        //     )->head(
        //         ...Head::create(
        //             $this->store(),
        //             PageTitle::create($this->store())->buildBookend(),
        //             $this->requestUriFull()
        //         )
        //     )->body(
        //         $content->html()
        //     );
        // }
        // print '';
    // }
}
