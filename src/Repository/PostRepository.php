<?php

namespace App\Repository;

use App\Entity\Post;
use DateTime;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\QueryBuilder;
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

    public function getPostsByCategoryID(int $categoryID, int $limit = 4, int $page = 1): array
    {
        return $this->getLatestPostsQueryWrapper(function (QueryBuilder $queryBuilder) use ($categoryID) {
            $this->setCategoryInQueryBuilder($queryBuilder, $categoryID);
        }, $limit, $page);
    }

    public function getPostsCount(array $params = []): int
    {
        $result = $this->getLatestPostsQueryWrapper(function (QueryBuilder $queryBuilder) use ($params) {
            $queryBuilder->select('count(post.id)')->setMaxResults(null);

            if ($params['category_id'] ?? false) {
                $this->setCategoryInQueryBuilder($queryBuilder, $params['category_id']);
            }

            if ($params['s'] ?? false) {
                $this->setSearchInQueryBuilder($queryBuilder, $params['s']);
            }

            if ($params['date'] ?? false) {
                $this->setDateInQueryBuilder(
                    $queryBuilder,
                    DateTime::createFromFormat(Post::DATE_FORMAT_FOR_SEARCH, $params['date'])
                );
            }
        }, 0, 1);

        return $result[0][1] ?? 0;
    }

    public function getLatestPosts(int $limit = 4, int $page = 1): array
    {
        return $this->getLatestPostsQueryWrapper(fn () => null, $limit, $page);
    }

    public function getPostsBySearch(array $params, int $limit = 4, int $page = 1): array
    {
        return $this->getLatestPostsQueryWrapper(function (QueryBuilder $queryBuilder) use ($params) {
            if ($params['s'] ?? false) {
                $this->setSearchInQueryBuilder($queryBuilder, $params['s']);
            }

            if ($params['date'] ?? false) {
                $this->setDateInQueryBuilder(
                    $queryBuilder,
                    DateTime::createFromFormat(Post::DATE_FORMAT_FOR_SEARCH, $params['date'])
                );
            }
        }, $limit, $page);
    }

    public function getTrendingPosts(int $limit = 5): array
    {
        return $this->getLatestPostsQueryWrapper(function (QueryBuilder $queryBuilder) {
            $queryBuilder->orderBy('post.views', 'DESC');
        }, $limit, 1);
    }

    public function getPostsByTagID(int $tagID, int $limit = 4, int $page = 1): array
    {
        return $this->getLatestPostsQueryWrapper(function (QueryBuilder $queryBuilder) use ($tagID) {
            $queryBuilder->innerJoin('post.tags', 'tags')
                ->where('tags.id = :id')
                ->setParameter('id', $tagID);
        }, $limit, $page);
    }

    private function getLatestPostsQueryWrapper(callable $callback, int $limit, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('post')
            ->orderBy('post.created_at', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($limit * ($page-1));

        $callback($queryBuilder);

        return $queryBuilder->getQuery()
            ->setFetchMode(Post::class, 'category', ClassMetadataInfo::FETCH_EAGER)
            ->getResult();
    }

    private function setCategoryInQueryBuilder(QueryBuilder $queryBuilder, int $categoryID)
    {
        $queryBuilder->andWhere('post.category = :id')
            ->setParameter('id', $categoryID);
    }

    private function setSearchInQueryBuilder(QueryBuilder $queryBuilder, string $query)
    {
        $queryBuilder->andWhere($queryBuilder->expr()->like('post.title', ':query'))
            ->setParameter('query', "%$query%");
    }

    private function setDateInQueryBuilder(QueryBuilder $queryBuilder, DateTimeInterface $date)
    {
        $queryBuilder->andWhere('DATE(post.created_at) = :date')
            ->setParameter('date', $date->format('Y-m-d'));
    }
}
