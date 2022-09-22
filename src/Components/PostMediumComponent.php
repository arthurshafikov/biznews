<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('post-medium')]
class PostMediumComponent
{
    public bool $showContent = false;
}
