<?php

namespace App\Controller\Auth;

use App\Form\RegistrationFormType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register_show', methods: ['GET'])]
    public function showRegistrationForm(): Response
    {
        return $this->returnRegisterFormResponse($this->createForm(RegistrationFormType::class));
    }

    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, UserService $userService): Response
    {
        $registrationForm = $this->createForm(RegistrationFormType::class);
        $registrationForm->handleRequest($request);
        if (!$registrationForm->isSubmitted() || !$registrationForm->isValid()) {
            return $this->returnRegisterFormResponse($registrationForm);
        }

        $userService->register([
            'name' => $registrationForm->get('name')->getData(),
            'email' => $registrationForm->get('email')->getData(),
            'password' => $registrationForm->get('password')->getData(),
        ]);

        $request->getSession()->getFlashBag()->add('session-message', [
            'message' => 'You have registered successfully',
        ]);

        return $this->redirectToRoute('app_login');
    }

    private function returnRegisterFormResponse(FormInterface $form): Response
    {
        return $this->render('auth/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
