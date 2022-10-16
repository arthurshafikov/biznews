<?php

namespace App\Service;

use App\Entity\User;
use App\Events\UserChangedEmail;
use App\Repository\UserRepository;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $hasher,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly TokenGeneratorService $tokenGeneratorService,
    ) {
    }

    public function register(array $params): void
    {
        $user = new User();
        $user->setName($params['name']);
        $user->setEmail($params['email']);
        $user->setVerified(false);
        $user->setPassword($this->hasher->hashPassword($user, $params['password']));
        $user->setCreatedAt(DateTimeImmutable::createFromMutable(new DateTime()));

        $this->eventDispatcher->dispatch(
            new UserChangedEmail(
                $user,
                $this->tokenGeneratorService->generateToken($user->getEmail())
            ),
            UserChangedEmail::NAME
        );

        $this->userRepository->add($user, true);
    }

    public function verifyToken(string $email, string $token): bool
    {
        $user = $this->userRepository->findOneBy([
            'email' => $email,
        ]);

        if (
            $user !== null &&
            $this->tokenGeneratorService->generateToken($user->getEmail()) === $token
        ) {
            $user->setVerified(true);
            $this->userRepository->add($user, true);

            return true;
        }

        return false;
    }
}
