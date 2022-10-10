<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsEventListener(event: UserRegistered::class, method: 'onUserRegistered')]
class SendUserVerificationEmail extends SendVerificationEmail
{
    protected const EMAIL_SUBJECT = 'Please verify your email address!';

    public function onUserRegistered(UserRegistered $event): void
    {
        $this->send($event->user->getEmail(), $this->urlGenerator->generate('app_verify', [
            'email' => $event->user->getEmail(),
            'token' => $event->token,
        ], UrlGeneratorInterface::ABSOLUTE_URL));
    }
}
