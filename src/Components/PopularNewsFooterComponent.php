<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('popular-news')]
class PopularNewsFooterComponent extends TrendingNewsComponent
{
    protected const POSTS_COUNT = 3;
}
