<?php
declare(strict_types=1);

namespace JoshBruce\Site\Documents;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use Nyholm\Psr7\Response;

use Symfony\Component\Finder\Finder as SymfonyFinder;

use Eightfold\Amos\SiteInterface;
use Eightfold\Amos\Sitemap as AmosSitemap;

class Sitemap
{
    public function __invoke(SiteInterface $site): Response
    {
        $iterator = (new SymfonyFinder())->files()->name('meta.json')
            ->in(
                $site->publicRoot()->toString()
            );

        return new Response(
            200,
            headers: [
                'Content-Type' => 'text/xml',
                'Charset' => 'utf-8'
            ],
            body: (string) AmosSitemap::create($iterator, $site)
        );
    }
}
