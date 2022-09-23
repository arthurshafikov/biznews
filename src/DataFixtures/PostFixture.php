<?php

namespace App\DataFixtures;

use App\Entity\Post;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class PostFixture extends Fixture implements DependentFixtureInterface
{
    private const IMAGES = [
        'news-700x435-1.jpg',
        'news-700x435-2.jpg',
        'news-700x435-3.jpg',
        'news-700x435-4.jpg',
        'news-700x435-5.jpg',
        'news-800x500-1.jpg',
        'news-800x500-2.jpg',
        'news-800x500-3.jpg',
    ];

    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $categories = $this->getCategories();
        for ($i = 0; $i < 50; $i++) {
            $post = new Post();
            $post->setCategory($this->faker->randomElement($categories));
            $post->setTitle($this->faker->realText(50));
            $post->setSlug($this->faker->slug);
            $post->setContent($this->faker->paragraph(100));
            $post->setImage($this->faker->randomElement(static::IMAGES));
            $post->setViews($this->faker->randomNumber());
            $post->setCreatedAt(DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-1 year')));
            $manager->persist($post);
        }
         $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixture::class,
        ];
    }

    private function getCategories(): array
    {
        $categories = [];

        for ($i = 0; $i < count(CategoryFixture::CATEGORIES); $i++) {
            $categories[] = $this->getReference('categories_' . $i);
        }

        return $categories;
    }
}
