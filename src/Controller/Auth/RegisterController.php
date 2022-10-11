<?php

namespace App\Controller\Auth;

use App\Entity\User;
use App\Events\UserChangedEmail;
use App\Form\RegistrationFormType;
use App\Service\TokenGeneratorService;
use DateTime;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly TokenGeneratorService $tokenGeneratorService
    ) {}

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
        $user->setVerified(false);
        $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
        $user->setCreatedAt(DateTimeImmutable::createFromMutable(new DateTime()));

        $entityManager->persist($user);
        $entityManager->flush();

        $request->getSession()->getFlashBag()->add('session-message',  [
            'message' => 'You have registered successfully',
        ]);

        $this->eventDispatcher->dispatch(
            new UserChangedEmail(
                $user,
                $this->tokenGeneratorService->generateToken($user->getEmail())
            ), UserChangedEmail::NAME
        );

        return $this->redirectToRoute('app_login');
    }
}
