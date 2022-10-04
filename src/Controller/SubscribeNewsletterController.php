<?php

namespace App\Controller;

use App\Entity\SubscribedEmail;
use App\Repository\SubscribedEmailRepository;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscribeNewsletterController extends AbstractController
{
    private const CREATED_AT_FORMAT_FOR_TOKEN = 'Y-m-d H-s-m';

    #[Route('/subscribe/newsletter', name: 'app_newsletter_subscribe')]
    public function subscribe(Request $request, SubscribedEmailRepository $repository): Response
    {
        $now = DateTimeImmutable::createFromMutable(new DateTime());

        $subscribeEmail = new SubscribedEmail();
        $subscribeEmail->setEmail($request->get('email'));
        $subscribeEmail->setToken($this->generateToken($request->get('email'), $now));
        $subscribeEmail->setVerified(false);
        $subscribeEmail->setCreatedAt($now);
        $repository->add($subscribeEmail, true);

        $request->getSession()->getFlashBag()->add('session-message',  [
            'title' => 'Congratulations!',
            'message' => 'You have subscribed to our newsletter, ' .
                'make sure to verify your address by following the instructions on your e-mail',
        ]);

        return new RedirectResponse($this->generateUrl('app_home'));
    }

    private function generateToken(string $email, DateTimeInterface $timestamp): string
    {
        return sha1($email . $timestamp->format(static::CREATED_AT_FORMAT_FOR_TOKEN));
    }
}
