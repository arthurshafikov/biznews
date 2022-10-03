<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use DateTime;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
    public function register(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $hasher): Response
    {
        $formData = $request->get('registration_form');
        $entityManager = $doctrine->getManager();

        $user = new User();
        $user->setName($formData['name']);
        $user->setAvatar($formData['avatar']);
        $user->setEmail($formData['email']);
        $user->setPassword($hasher->hashPassword($user, $formData['password']));
        $user->setVerified(false);
        $user->setCreatedAt(DateTimeImmutable::createFromMutable(new DateTime()));

        $entityManager->persist($user);
        $entityManager->flush();

        $request->getSession()->getFlashBag()->add('session-message',  [
            'message' => 'You have registered successfully',
        ]);

        return $this->redirectToRoute('app_login');
    }
}
