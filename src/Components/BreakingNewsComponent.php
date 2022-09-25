<?php

namespace App\Components;

use App\Repository\PostRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('breaking-news')]
class BreakingNewsComponent
{
    public function __construct(private readonly PostRepository $postRepository)
    {
    }

    public function getBreakingNews(): array
    {
        return $this->postRepository->getTrendingPosts(3);
    }
}
