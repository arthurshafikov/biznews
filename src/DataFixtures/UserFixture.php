<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    protected Generator $faker;

    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setName('Admin user');
        $user->setEmail('test@test.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'secret'));
        $user->setVerified(true);
        $user->setRoles([User::ADMIN_ROLE]);
        $user->setCreatedAt(DateTimeImmutable::createFromMutable(new DateTime()));
        $manager->persist($user);

        for ($i = 1; $i <= 3; $i++) {
            $user = new User();
            $user->setName($this->faker->name);
            $user->setEmail($this->faker->safeEmail);
            $user->setPassword($this->passwordHasher->hashPassword($user, $this->faker->password));
            $user->setVerified(true);
            $user->setRoles([]);
            $user->setCreatedAt(DateTimeImmutable::createFromMutable(new DateTime()));
            $manager->persist($user);
            $this->setReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}
