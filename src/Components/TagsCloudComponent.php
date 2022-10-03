<?php

namespace App\Components;

use App\Repository\TagRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('tags-cloud')]
class TagsCloudComponent
{
    public function __construct(private readonly TagRepository $tagRepository)
    {
    }

    public function getTags(): array
    {
        return $this->tagRepository->findAll();
    }
}
