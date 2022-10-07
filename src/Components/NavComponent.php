<?php

namespace App\Components;

use App\Repository\CategoryRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('nav')]
class NavComponent
{
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    public function getCategories(): array
    {
        return $this->categoryRepository->findAll();
    }
}
