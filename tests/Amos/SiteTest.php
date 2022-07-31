<?php
declare(strict_types=1);

namespace Eightfold\Amos\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Amos\Site;

use Eightfold\Amos\Templates\Page;

class SiteTest extends TestCase
{
    /**
     * @test
     */
    public function can_have_controllers(): void
    {
        $this->assertSame(
            Page::class,
            Site::init(
                'http://amos.com',
                __DIR__ . '/content-test'
            )->setTemplates(Page::class)->template(at: 'default')
        );
    }

    /**
     * @test
     */
    public function site_can_be_initialized(): void
    {
        $this->assertSame(
            'http://amos.com',
            Site::init(
                'http://amos.com',
                __DIR__ . '/content-test'
            )->domain()
        );

        $this->assertSame(
            'http://amos.com',
            Site::singleton()->domain()
        );
    }
    /**
     * @test
     */
    public function site_exists(): void
    {
        $this->assertTrue(
            class_exists(Site::class)
        );
    }
}
