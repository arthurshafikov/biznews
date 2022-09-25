<?php

namespace App\Components;

use App\Entity\Post;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('post-medium')]
class PostMediumComponent
{
    public Post $post;
    public bool $showContent = false;
}
