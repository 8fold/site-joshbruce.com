<?php
declare(strict_types=1);

namespace Eightfold\Amos\PageComponents;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Psr\Http\Message\RequestInterface;

use Eightfold\Amos\Site;

use Eightfold\Amos\Content;
use Eightfold\Amos\Meta;

use Eightfold\Amos\Markdown;

class PageTitle implements Buildable
{
    public static function create(Site $site): PageTitle
    {
        return new self($site);
    }

    final private function __construct(private Site $site)
    {
    }

    public function site(): Site
    {
        return $this->site;
    }

//     private function content(): Content
//     {
//         return $this->contentIn;
//     }
//
//     private function request(): RequestInterface
//     {
//         return $this->request;
//     }

    public function build(): string
    {
        $path = $this->site()->requestPath();

        $pathParts = explode('/', $path);
        $filtered  = array_filter($pathParts);

        $titles = [];
        while (count($filtered) > 0) {
            $path = '/' . implode('/', $filtered) . '/';
            $meta = $this->site()->meta(at: $path);
            if (property_exists($meta, 'title') === false) {
                $titles[] = '';
            }
            $titles[] = Markdown::convertTitle($meta->title);

            array_pop($filtered);
        }

        $meta = $this->site()->meta(at: '/');
        if (property_exists($meta, 'title') === false) {
            $titles[] = '';

        } else {
            $titles[] = Markdown::convertTitle($meta->title);

        }

        $titles = array_filter($titles);

        return trim(implode(' | ', $titles));
    }

    public function __toString(): string
    {
        return $this->build();
    }
}
