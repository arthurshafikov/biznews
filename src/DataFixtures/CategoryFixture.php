<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    public const CATEGORIES = [
        'Business',
        'Sport',
        'Finance',
        'Politics',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (static::CATEGORIES as $id => $categoryName) {
             $category = new Category();
             $category->setName($categoryName);
             $category->setSlug(strtolower($categoryName));
             $manager->persist($category);

             $this->setReference('category_' . $id, $category);
        }

        $manager->flush();
    }
}
