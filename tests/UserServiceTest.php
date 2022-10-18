<?php

namespace App\Tests;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UserServiceTest extends KernelTestCase
{
    public function setUp(): void
    {
        self::bootKernel();
        $this->truncateEntities([
            User::class,
        ]);
    }

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

    private function truncateEntities(array $entities)
    {
        $container = static::getContainer();
        $em = $container->get(EntityManagerInterface::class);
        $connection = $em->getConnection();
        $databasePlatform = $connection->getDatabasePlatform();
        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
        }
        foreach ($entities as $entity) {
            $query = $databasePlatform->getTruncateTableSQL(
                $em->getClassMetadata($entity)->getTableName()
            );
            $connection->executeUpdate($query);
        }
        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
        }
    }
}
