<?php

namespace App\Listeners;

use App\Entity\Setting;
use App\Events\SubscribedEmailCreated;
use App\Repository\SettingRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Throwable;
use Twig\Environment;

#[AsEventListener(event: SubscribedEmailCreated::class, method: 'onSubscribedEmailCreated')]
class SendSubscriptionVerificationEmail
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly SettingRepository $settingRepository,
        private readonly LoggerInterface $logger,
        private readonly Environment $twig
    ) {
    }

    public function onSubscribedEmailCreated(SubscribedEmailCreated $event): void
    {
        try {
            $emailHTML = $this->twig->render('emails/email-verification.html.twig', [
                'url' => $this->urlGenerator->generate('app_newsletter_confirm', [
                    'email' => $event->subscribedEmail->getEmail(),
                    'token' => $event->subscribedEmail->getToken(),
                ], UrlGeneratorInterface::ABSOLUTE_URL)
            ]);
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            return;
        }

        $email = (new Email())
            ->from($this->settingRepository->getSettingValue(Setting::COMPANY_EMAIL))
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
