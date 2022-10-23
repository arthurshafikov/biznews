<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class CommentFixture extends Fixture implements DependentFixtureInterface
{
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            $this->getReference('user_1'),
            $this->getReference('user_2'),
            $this->getReference('user_3'),
        ];

        for ($postNum = 0; $postNum < PostFixture::POSTS_COUNT; $postNum++) {
            for ($commentsCount = 0; $commentsCount < mt_rand(0, 4); $commentsCount++) {
                $comment = new Comment();
                $comment->setUser($users[array_rand($users)]);
                $comment->setPost($this->getReference('post_' . $postNum));
                $comment->setParent(null);
                $comment->setContent($this->faker->realText(100));
                $manager->persist($comment);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PostFixture::class,
            UserFixture::class,
        ];
    }
}
