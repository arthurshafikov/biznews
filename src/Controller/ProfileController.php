<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Events\UserChangedEmail;
use App\Form\ProfileFormType;
use App\Repository\UserRepository;
use App\Service\TokenGeneratorService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfileController extends AbstractController
{
    public function __construct(
        private readonly SluggerInterface $slugger,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly TokenGeneratorService $tokenGeneratorService
    ) {}

    #[Route('/profile', name: 'app_profile', methods: ['GET'])]
    public function showProfile(): Response
    {
        return $this->returnForm($this->createForm(ProfileFormType::class, $this->getUser()));
    }

    #[Route('/profile', name: 'app_profile_save', methods: ['POST'])]
    public function saveProfile(Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $profileForm = $this->createForm(ProfileFormType::class, $user);
        $userOldEmail = $user->getEmail();
        $profileForm->handleRequest($request);
        if (!$profileForm->isValid()) {
            return $this->returnForm($profileForm);
        }

        /** @var $user User */
        $user = $profileForm->getData();
        if ($newAvatarFile = $profileForm->get('avatar')->getData()) {
            try {
                $newAvatarFilename = $this->uploadNewAvatar($newAvatarFile);
                $this->removeOldAvatarFile($user->getAvatar());
                $user->setAvatar($newAvatarFilename);
            } catch (Exception $exception) {
                $profileForm
                    ->get('avatar')
                    ->addError(new FormError($exception->getMessage()));

                return $this->returnForm($profileForm);
            }
        }

        if ($userOldEmail !== $user->getEmail()) {
            $user->setVerified(false);

            $this->eventDispatcher->dispatch(
                new UserChangedEmail(
                    $user,
                    $this->tokenGeneratorService->generateToken($user->getEmail())
                ), UserChangedEmail::NAME
            );
        }
        $userRepository->add($user, true);

        $request->getSession()->getFlashBag()->add('session-message',  [
            'message' => 'You have successfully changed profile info!',
        ]);

        return $this->redirectToRoute('app_home');
    }

    private function uploadNewAvatar(UploadedFile $newAvatarFile): string
    {
        $newAvatarFilename = $this->slugger->slug(pathinfo($newAvatarFile->getClientOriginalName(), PATHINFO_FILENAME))
            . '-' . uniqid() . '.' . $newAvatarFile->guessExtension();

        $newAvatarFile->move(Post::STORAGE_FOLDER, $newAvatarFilename);

        return $newAvatarFilename;
    }

    private function removeOldAvatarFile(string $oldAvatarFilename): void
    {
        (new Filesystem())->remove(Post::STORAGE_FOLDER . '/' . $oldAvatarFilename);
    }

    private function returnForm(FormInterface $form): Response
    {
        return $this->render('profile/index.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }
}
