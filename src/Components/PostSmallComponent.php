<?php

namespace App\Components;

use App\Entity\Post;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('post-small')]
class PostSmallComponent
{
    public Post $post;
}
