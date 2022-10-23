<?php

namespace App\Service;

use App\Entity\SubscribedEmail;
use App\Events\SubscribedEmailCreated;
use App\Repository\SubscribedEmailRepository;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SubscribedNewsletterService
{
    public function __construct(
        private readonly SubscribedEmailRepository $repository,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly TokenGeneratorService $tokenGeneratorService
    ) {
    }

    public function add(string $email): void
    {
        $subscribeEmail = new SubscribedEmail();
        $subscribeEmail->setEmail($email);
        $subscribeEmail->setVerified(false);
        $this->repository->add($subscribeEmail, true);

        $this->eventDispatcher->dispatch(
            new SubscribedEmailCreated(
                $subscribeEmail,
                $this->tokenGeneratorService->generateToken($subscribeEmail->getEmail())
            ),
            SubscribedEmailCreated::NAME
        );
    }

    public function confirm(string $email, string $token): bool
    {
        $subscribedEmail = $this->repository->findOneBy([
            'email' => $email,
        ]);

        if (
            $subscribedEmail !== null &&
            $this->tokenGeneratorService->generateToken($subscribedEmail->getEmail()) === $token
        ) {
            $subscribedEmail->setVerified(true);
            $this->repository->add($subscribedEmail, true);

            return true;
        }

        return false;
    }
}
