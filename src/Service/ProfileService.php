<?php

namespace App\Service;

use App\Entity\Post;
use App\Entity\User;
use App\Events\UserChangedEmail;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfileService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly SluggerInterface $slugger,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly TokenGeneratorService $tokenGeneratorService
    ) {
    }

    public function update(User $user, string $userOldEmail, ?UploadedFile $avatar): void
    {
        if ($avatar) {
            $newAvatarFilename = $this->uploadNewAvatar($avatar);
            if ($user->getAvatar() !== null) {
                $this->removeOldAvatarFile($user->getAvatar());
            }
            $user->setAvatar($newAvatarFilename);
        }

        if ($userOldEmail !== $user->getEmail()) {
            $user->setVerified(false);

            $this->eventDispatcher->dispatch(
                new UserChangedEmail(
                    $user,
                    $this->tokenGeneratorService->generateToken($user->getEmail())
                ),
                UserChangedEmail::NAME
            );
        }
        $this->userRepository->add($user, true);
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
}
