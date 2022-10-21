<?php

namespace App\Tests\Integration\Service;

use App\EntityFactory\UserFactory;
use App\Repository\UserRepository;
use App\Service\TokenGeneratorService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UserServiceTest extends KernelTestCase
{
    public function testRegister(): void
    {
        $container = static::getContainer();
        $params = [
            'name' => 'New User',
            'email' => 'test@email.com',
            'password' => 'pass',
        ];
        $mockEventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $mockEventDispatcher
            ->expects(self::once())
            ->method('dispatch')
            ->willReturnSelf();
        $container->set(EventDispatcherInterface::class, $mockEventDispatcher);
        /** @var UserService $userService */
        $userService = $container->get(UserService::class);
        $userRepository = $container->get(UserRepository::class);

        $userService->register($params);

        /** @var \App\Entity\User $user */
        $user = $userRepository->findOneBy([
            'email' => $params['email'],
        ]);
        $this->assertSame('New User', $user->getName());
        $this->assertSame('test@email.com', $user->getEmail());
        $this->assertFalse($user->isVerified());
    }

    public function testVerifyToken(): void
    {
        $container = static::getContainer();
        /** @var User $user */
        $user = $container->get(UserFactory::class)->createFake();
        $mockTokenGeneratorService = $this->createMock(TokenGeneratorService::class);
        $mockTokenGeneratorService
            ->expects(self::once())
            ->method('generateToken')
            ->willReturn('someGeneratedToken');
        $container->set(TokenGeneratorService::class, $mockTokenGeneratorService);
        /** @var UserService $userService */
        $userService = $container->get(UserService::class);

        $result = $userService->verifyToken($user->getEmail(), 'someGeneratedToken');

        $this->assertTrue($result);
        $this->assertTrue($user->isVerified());
    }

    public function testVerifyTokenUserNotExists(): void
    {
        $container = static::getContainer();
        /** @var UserService $userService */
        $userService = $container->get(UserService::class);

        $result = $userService->verifyToken('non-exists@email.com', 'uselessToken');

        $this->assertFalse($result);
    }
}
