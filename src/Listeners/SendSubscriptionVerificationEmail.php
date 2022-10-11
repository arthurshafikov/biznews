<?php

namespace App\Listeners;

use App\Events\SubscribedEmailCreated;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsEventListener(event: SubscribedEmailCreated::class, method: 'onSubscribedEmailCreated')]
class SendSubscriptionVerificationEmail extends SendVerificationEmail
{
    protected const EMAIL_SUBJECT = 'Please verify your subscription!';

    public function onSubscribedEmailCreated(SubscribedEmailCreated $event): void
    {
        $this->send($event->subscribedEmail->getEmail(), $this->urlGenerator->generate('app_newsletter_confirm', [
            'email' => $event->subscribedEmail->getEmail(),
            'token' => $event->token,
        ], UrlGeneratorInterface::ABSOLUTE_URL));
    }
}
