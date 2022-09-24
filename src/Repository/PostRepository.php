<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function add(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getPostsByCategoryID(int $categoryID, int $limit = 4): array
    {
        return $this->createQueryBuilder('post')
            ->andWhere('post.category = :id')
            ->setParameter('id', $categoryID)
            ->orderBy('post.created_at', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->setFetchMode(Post::class, 'category', ClassMetadataInfo::FETCH_EAGER)
            ->getResult();
    }

    public function getPostsWhereTagIsBreaking(int $limit = 3): array
    {
        return $this->createQueryBuilder('post')
            ->innerJoin('post.tags', 'tags')
            ->where('tags.name = :name')
            ->setParameter('name', "Breaking") // todo remove hardcode
            ->orderBy('post.created_at', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
