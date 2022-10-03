<?php

namespace App\Components;

use App\Repository\CategoryRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('categories-cloud')]
class CategoriesCloudComponent
{
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    public function getCategories(): array
    {
        return $this->categoryRepository->findAll();
    }
}
