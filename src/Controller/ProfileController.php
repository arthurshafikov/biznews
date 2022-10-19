<?php

namespace App\Controller;

use App\Form\ProfileFormType;
use App\Service\ProfileService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile', methods: ['GET'])]
    public function showProfile(): Response
    {
        return $this->returnForm($this->createForm(ProfileFormType::class, $this->getUser()));
    }

    #[Route('/profile', name: 'app_profile_save', methods: ['POST'])]
    public function saveProfile(Request $request, ProfileService $profileService): Response
    {
        $user = $this->getUser();
        $profileForm = $this->createForm(ProfileFormType::class, $user);
        $userOldEmail = $user->getEmail();
        $profileForm->handleRequest($request);
        if (!$profileForm->isValid()) {
            return $this->returnForm($profileForm);
        }

        try {
            $profileService->update($profileForm->getData(), $userOldEmail, $profileForm->get('avatar')->getData());
        } catch (Exception $exception) {
            $profileForm
                ->get('avatar')
                ->addError(new FormError($exception->getMessage()));

            return $this->returnForm($profileForm);
        }

        $request->getSession()->getFlashBag()->add('session-message', [
            'message' => 'You have successfully changed profile info!',
        ]);

        return $this->redirectToRoute('app_profile');
    }

    private function returnForm(FormInterface $form): Response
    {
        return $this->render('profile/index.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }
}
