<?php

namespace App\Controller;

use App\Entity\SubscribedEmail;
use App\Events\SubscribedEmailCreated;
use App\Repository\SubscribedEmailRepository;
use App\Service\TokenGeneratorService;
use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscribeNewsletterController extends AbstractController
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly TokenGeneratorService $tokenGeneratorService
    ) {
    }

    #[Route('/subscribe/newsletter', name: 'app_newsletter_subscribe')]
    public function subscribe(Request $request, SubscribedEmailRepository $repository): Response
    {
        $now = DateTimeImmutable::createFromMutable(new DateTime());

        $subscribeEmail = new SubscribedEmail();
        $subscribeEmail->setEmail($request->get('email'));
        $subscribeEmail->setVerified(false);
        $subscribeEmail->setCreatedAt($now);
        $repository->add($subscribeEmail, true);

        $this->eventDispatcher->dispatch(
            new SubscribedEmailCreated(
                $subscribeEmail,
                $this->tokenGeneratorService->generateToken($subscribeEmail->getEmail())
            ),
            SubscribedEmailCreated::NAME
        );

        $request->getSession()->getFlashBag()->add('session-message', [
            'title' => 'Congratulations!',
            'message' => 'You have subscribed to our newsletter, ' .
                'make sure to verify your address by following the instructions on your e-mail',
        ]);

        return new RedirectResponse($this->generateUrl('app_home'));
    }

    #[Route('/subscribe/confirm', name: 'app_newsletter_confirm')]
    public function confirmSubscription(Request $request, SubscribedEmailRepository $repository): Response
    {
        $subscribedEmail = $repository->findOneBy([
            'email' => $request->get('email'),
        ]);

        if (
            $subscribedEmail !== null &&
            $this->tokenGeneratorService->generateToken($subscribedEmail->getEmail()) === $request->get('token')
        ) {
            $subscribedEmail->setVerified(true);
            $repository->add($subscribedEmail, true);

            $request->getSession()->getFlashBag()->add('session-message', [
                'title' => 'Success!',
                'message' => 'You have successfully verified your subscription!',
            ]);
        } else {
            $request->getSession()->getFlashBag()->add('session-message', [
                'title' => 'Error!',
                'message' => 'Wrong token!',
                'type' => 'error',
            ]);
        }

        return new RedirectResponse($this->generateUrl('app_home'));
    }
}
