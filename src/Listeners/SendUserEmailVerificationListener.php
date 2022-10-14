<?php

namespace App\Listeners;

use App\Events\UserChangedEmail;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsEventListener(event: UserChangedEmail::class, method: 'onUserEmailChanged')]
class SendUserEmailVerificationListener extends SendEmailListener
{
    protected const EMAIL_SUBJECT = 'Please verify your email address!';

    public function onUserEmailChanged(UserChangedEmail $event)
    {
        $this->send($event->user->getEmail(), 'emails/email-verification.html.twig', [
            'url' => $this->urlGenerator->generate('app_verify', [
                'email' => $event->user->getEmail(),
                'token' => $event->token,
            ], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
    }
}
