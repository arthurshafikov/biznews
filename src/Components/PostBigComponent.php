<?php

namespace App\Components;

use App\Entity\Post;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('post-big')]
class PostBigComponent
{
    public Post $post;
}
