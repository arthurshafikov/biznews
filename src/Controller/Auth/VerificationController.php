<?php

namespace App\Controller\Auth;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VerificationController extends AbstractController
{
    #[Route('/verify', name: 'app_verify')]
    public function verify(Request $request, UserService $userService): Response
    {
        if ($userService->verifyToken($request->get('email'), $request->get('token'))) {
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
