<?php
declare(strict_types=1);

namespace JoshBruce\Site\Partials;

use DateTime;

use Eightfold\HTMLBuilder\Element;

use Eightfold\CommonMarkPartials\PartialInterface;
use Eightfold\CommonMarkPartials\PartialInput;

class DateBlock implements PartialInterface
{
    public function __invoke(PartialInput $input, array $extras = []): string
    {
        if (array_key_exists('meta', $extras) === false) {
            return '';
        }

        $meta = $extras['meta'];
        $times = [];
        if ($meta->hasProperty('created')) {
            $label      = 'Created';
            $date       = $meta->created();
            $schemaProp = 'dateCreated';

            $times[] = self::timestamp($label, $date, $schemaProp);
        }

        if ($meta->hasProperty('moved')) {
            $label = 'Moved';
            $date  = $meta->moved();

            $times[] = self::timestamp($label, $date);
        }

        if ($meta->hasProperty('updated')) {
            $label      = 'Updated';
            $date       = $meta->updated();
            $schemaProp = 'dateModified';

            $times[] = self::timestamp($label, $date, $schemaProp);
        }

        if (count($times) === 0) {
            return '';
        }
        return (string) Element::div(...$times)->props('is dateblock');
    }

    private static function timestamp(
        string $label,
        string|int|false $date = false,
        string $schemaProp = ''
    ): Element|string {
        if (! $date) {
            return '';
        }

        if ($date = DateTime::createFromFormat('Ymd', strval($date))) {
            $time = (string) Element::time($date->format('M j, Y'))
                ->props(
                    (strlen($schemaProp) > 0) ? "property {$schemaProp}" : '',
                    'content ' . $date->format('Y-m-d')
                );
            return Element::p("{$label}: {$time}");
        }
        return '';
    }
}
