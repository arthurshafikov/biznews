<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TagFixture extends Fixture implements DependentFixtureInterface
{
    private const TAGS = [
        'Breaking',
        'Featured',
        'Lifestyle',
        'Education',
        'Entertainment',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (static::TAGS as $id => $tagName) {
            $tag = new Tag();
            $tag->setName($tagName);
            $tag->setSlug(strtolower($tagName));
            for ($i = 0; $i < 9; $i++) {
                $tag->addPost($this->getReference('post_' . mt_rand(0, 49)));
            }

            $manager->persist($tag);

            $this->setReference('tag_' . $id, $tag);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PostFixture::class,
        ];
    }
}
