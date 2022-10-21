<?php

namespace App\Tests\Integration\Service;

use App\EntityFactory\UserFactory;
use App\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProfileServiceTest extends KernelTestCase
{
    public function testUpdateNewEmail(): void
    {
        $container = static::getContainer();
        /** @var ProfileService $profileService */
        $profileService = $container->get(ProfileService::class);
        /** @var User $user */
        $user = $container->get(UserFactory::class)->createFake();
        $user->setName('New Name');

        $profileService->update($user, 'oldEmail@email.com');

        $this->assertFalse($user->isVerified());
        $this->assertSame('New Name', $user->getName());
    }
}
