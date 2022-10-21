<?php

namespace App\EntityFactory;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use DateTimeImmutable;
use Faker\Factory;
use Faker\Generator;

class UserFactory
{
    private Generator $faker;

    public function __construct(private readonly UserRepository $userRepository)
    {
        $this->faker = Factory::create();
    }

    public function createFake(array $params = []): User
    {
        $user = new User();
        $user->setEmail($this->faker->safeEmail());
        $user->setName($this->faker->name());
        $user->setAvatar('default.png');
        $user->setPassword('812yjasfjah82ydhj2doa32');
        $user->setVerified(false);
        $user->setRoles([]);
        $user->setCreatedAt(DateTimeImmutable::createFromMutable(new DateTime()));

        if (!empty($params)) {
            foreach ($params as $param => $value) {
                $paramName = str_replace(' ', '', ucwords(str_replace('_', ' ', $param)));
                $user->{"set$paramName"}($value);
            }
        }

        $this->userRepository->add($user, true);

        return $user;
    }
}
