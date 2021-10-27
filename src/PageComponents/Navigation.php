<?php

namespace JoshBruce\Site\PageComponents;

use Stringable;

use Eightfold\XMLBuilder\Contracts\Buildable;
use Eightfold\HTMLBuilder\Element as HtmlElement;

use JoshBruce\Site\Content;

class Navigation implements Buildable, Stringable
{
    public static function create(Content $content): Navigation
    {
        return new Navigation($content);
    }

    public function __construct(private Content $content)
    {
    }

    private function content(): Content
    {
        return $this->content;
    }

    public function build(): string
    {
        return HtmlElement::nav(
            HtmlElement::form(
                HtmlElement::div(
                    HtmlElement::label('navigation: ')->props(
                        'id change-page-select-label',
                        'for change-page-select'
                    ),
                    HtmlElement::select(
                        HtmlElement::option('home')->props(
                            'value /',
                            'selected selected'
                        ),
                        HtmlElement::optgroup(
                            HtmlElement::option('Overview')
                                ->props('value /finances'),
                            HtmlElement::option('Investment policy')
                                ->props('value /finances/investment-policy'),
                            HtmlElement::option('Paycheck to paycheck')
                                ->props('value /finances/building-wealth-paycheck-to-paycheck')
                        )->props('label Finances'),
                        HtmlElement::optgroup(
                            HtmlElement::option('Overview')
                                ->props('value /design-your-life'),
                            HtmlElement::option('Motivators')
                                ->props('value /design-your-life/motivators')
                        )->props('label Design your life'),
                        HtmlElement::optgroup(
                            HtmlElement::option('Overview')
                                ->props('value /software-development'),
                            HtmlElement::option('Why donʼt you use')
                                ->props('value /software-development/why-dont-you-use')
                        )->props('label Software development')
                    )->props(
                        'id change-page-select',
                        'name change-page-select'
                    )
                )->props('is form-control'),
                HtmlElement::button('Go!')
            )->props('action /', 'method post'),
        )->props('id main-nav-form');
    }

    public function __toString(): string
    {
        return $this->build();
    }
}
