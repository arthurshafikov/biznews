<?php

namespace App\Controller\Auth;

use App\Entity\User;
use App\Form\RegistrationFormType;
use DateTime;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register_show', methods: ['GET'])]
    public function showRegistrationForm(): Response
    {
        return $this->render('auth/register.html.twig', [
            'form' => $this->createForm(RegistrationFormType::class)->createView(),
        ]);
    }

    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(
        Request $request,
        ManagerRegistry $doctrine,
        UserPasswordHasherInterface $hasher,
    ): Response {
        $entityManager = $doctrine->getManager();

        $userForm = $this->createForm(RegistrationFormType::class);
        $userForm->handleRequest($request);
        if (!$userForm->isValid()) {
            return $this->render('auth/register.html.twig', [
                'form' => $userForm->createView(),
            ]);
        }

        /**
         * @var $user User
         */
        $user = $userForm->getData();
        $user->setAvatar('default.jpg');
        $user->setVerified(false);
        $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
        $user->setCreatedAt(DateTimeImmutable::createFromMutable(new DateTime()));

        $entityManager->persist($user);
        $entityManager->flush();

        $request->getSession()->getFlashBag()->add('session-message',  [
            'message' => 'You have registered successfully',
        ]);

        return $this->redirectToRoute('app_login');
    }
}
