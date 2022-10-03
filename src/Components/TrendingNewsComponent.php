<?php

namespace App\Components;

use App\Repository\PostRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('trending-news')]
class TrendingNewsComponent
{
    protected const POSTS_COUNT = 5;

    public function __construct(protected readonly PostRepository $postRepository)
    {
    }

    public function getTrendingNews(): array
    {
        return $this->postRepository->getTrendingPosts(static::POSTS_COUNT);
    }
}
