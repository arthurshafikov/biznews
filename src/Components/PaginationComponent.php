<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('pagination')]
class PaginationComponent
{
    public int $lastPage;
    public string $paginationPath;
}
