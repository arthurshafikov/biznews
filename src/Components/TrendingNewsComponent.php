<?php

namespace App\Components;

use App\Repository\PostRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('trending-news')]
class TrendingNewsComponent
{
    public function __construct(private readonly PostRepository $postRepository)
    {
    }

    public function getTrendingNews(): array
    {
        return $this->postRepository->getTrendingPosts();
    }
}
