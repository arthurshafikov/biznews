<?php

namespace App\Controller\Auth;

use App\Repository\UserRepository;
use App\Service\TokenGeneratorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VerificationController extends AbstractController
{
    public function __construct(private readonly TokenGeneratorService $tokenGeneratorService)
    {
    }

    #[Route('/verify', name: 'app_verify')]
    public function verify(Request $request, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy([
            'email' => $request->get('email'),
        ]);

        if (
            $user !== null &&
            $this->tokenGeneratorService->generateToken($user->getEmail()) === $request->get('token')
        ) {
            $user->setVerified(true);
            $userRepository->add($user, true);

            $request->getSession()->getFlashBag()->add('session-message', [
                'title' => 'Success!',
                'message' => 'You have successfully verified your email!',
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
