<?php

namespace App\Repository;

use App\Entity\SubscribedEmail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SubscribedEmail>
 *
 * @method SubscribedEmail|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubscribedEmail|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubscribedEmail[]    findAll()
 * @method SubscribedEmail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscribedEmailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscribedEmail::class);
    }

    public function add(SubscribedEmail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SubscribedEmail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
