<?php

namespace App\Listeners;

use App\Entity\Setting;
use App\Repository\SettingRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Throwable;
use Twig\Environment;

abstract class SendEmailListener
{
    protected const EMAIL_SUBJECT = "";

    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly SettingRepository $settingRepository,
        private readonly LoggerInterface $logger,
        private readonly Environment $twig,
        protected readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    protected function send(string $to, string $template, array $params): void
    {
        try {
            $emailHTML = $this->twig->render($template, $params);
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            return;
        }

        $email = (new Email())
            ->from($this->settingRepository->getSettingValue(Setting::COMPANY_EMAIL))
            ->to($to)
            ->subject(static::EMAIL_SUBJECT)
            ->html($emailHTML);

        try {
            $this->mailer->send($email);
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
