<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends Controller
{
    #[Route('/register', name: 'app_register_show', methods: ['GET'])]
    public function showRegistrationForm(): Response
    {
        $registrationForm = $this->createForm(RegistrationFormType::class, options: [
            'action' => $this->generateUrl('app_register'),
        ]);

        return $this->render('auth/register.html.twig', [
            'form' => $registrationForm->createView(),
        ]);
    }

    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request): Response
    {
        return $this->redirectToRoute('app_home');
    }
}
