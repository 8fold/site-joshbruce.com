<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use DateTime;

use Eightfold\XMLBuilder\Contracts\Buildable;

use Eightfold\HTMLBuilder\Element;

use Eightfold\Amos\Site;

class DateBlock implements Buildable
{
    public static function create(Site $site): self
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

    private static function timestamp(
        string $label,
        string|int|false $date = false,
        string $schemaProp = ''
    ): Element|string {
        if (! $date) {
            return '';
        }

        // TODO: Should be a way to abstract this - see PlainTextFile
        if ($date = DateTime::createFromFormat('Ymd', strval($date))) {
            $time = Element::time($date->format('M j, Y'))
                ->props(
                    (strlen($schemaProp) > 0) ? "property {$schemaProp}" : '',
                    'content ' . $date->format('Y-m-d')
                )->build();
            return Element::p("{$label}: {$time}");
        }
        return '';
    }

    public function build(): string
    {
        $meta = $this->site()->meta(at: $this->site()->requestPath());
        if ($meta === false) {
            return '';
        }

        $times = [];

        if (property_exists($meta, 'created')) {
            $label      = 'Created';
            $date       = $meta->created;
            $schemaProp = 'dateCreated';

            $times[] = self::timestamp($label, $date, $schemaProp);
        }

        if (property_exists($meta, 'moved')) {
            $label = 'Moved';
            $date  = $meta->moved;

            $times[] = self::timestamp($label, $date);
        }

        if (property_exists($meta, 'updated')) {
            $label      = 'Updated';
            $date       = $meta->updated;
            $schemaProp = 'dateModified';

            $times[] = self::timestamp($label, $date, $schemaProp);
        }

        if (count($times) === 0) {
            return '';
        }
        return Element::div(...$times)->props('is dateblock')->build();
    }

    public function __toString(): string
    {
        return $this->build();
    }
}
