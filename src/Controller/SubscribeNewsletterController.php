<?php

namespace App\Controller;

use App\Service\SubscribedEmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscribeNewsletterController extends AbstractController
{
    public function __construct(private readonly SubscribedEmailService $subscribedEmailService)
    {
    }

    #[Route('/subscribe/newsletter', name: 'app_newsletter_subscribe')]
    public function subscribe(Request $request): Response
    {
        $this->subscribedEmailService->add($request->get('email'));

        $request->getSession()->getFlashBag()->add('session-message', [
            'title' => 'Congratulations!',
            'message' => 'You have subscribed to our newsletter, ' .
                'make sure to verify your address by following the instructions on your e-mail',
        ]);

        return new RedirectResponse($this->generateUrl('app_home'));
    }

    #[Route('/subscribe/confirm', name: 'app_newsletter_confirm')]
    public function confirmSubscription(Request $request): Response
    {
        if ($this->subscribedEmailService->confirm($request->get('email'), $request->get('token'))) {
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
