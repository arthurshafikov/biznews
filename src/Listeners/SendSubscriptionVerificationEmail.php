<?php

namespace App\Listeners;

use App\Events\SubscribedEmailCreated;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Throwable;
use Twig\Environment;

#[AsEventListener(event: SubscribedEmailCreated::class, method: 'onSubscribedEmailCreated')]
class SendSubscriptionVerificationEmail
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly LoggerInterface $logger,
        private readonly Environment $twig
    ) {
    }

    public function onSubscribedEmailCreated(SubscribedEmailCreated $event): void
    {
        try {
            $emailHTML = $this->twig->render('emails/subscription-verification.html.twig', [
                'email' => $event->subscribedEmail->getEmail(),
                'token' => $event->subscribedEmail->getToken(),
            ]);
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            return;
        }

        $email = (new Email())
            ->from('main@biznews.com') // todo config?
            ->to($event->subscribedEmail->getEmail())
            ->subject('Please verify your subscription!')
            ->html($emailHTML);

        try {
            $this->mailer->send($email);
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
