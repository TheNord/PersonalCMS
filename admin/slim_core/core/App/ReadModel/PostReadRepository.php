<?php

namespace App\ReadModel;

use App\Entity\Post\Post;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Slim\Container;

class PostReadRepository
{
    private $em;

    public function __construct(\Slim\Container $container)
    {
        $this->em = $container->get(EntityManager::class);
    }

    public function countAll(): int
    {
        $count = $this->em
            ->createQueryBuilder()
            ->select('count(id)')
            ->from(Post::class, 'id')
            ->getQuery()
            ->getSingleScalarResult();

        return $count;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return Paginator
     */
    public function all(int $offset, int $limit): Paginator
    {
        $dql = "SELECT p FROM App\Entity\Post\Post p";

        $query = $this->em->createQuery($dql)
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $paginator = new Paginator($query, $fetchJoinCollection = true);

        return $paginator;
    }

    /**
     * @param int $id
     * @return Post|object|null
     */
    public function find(int $id): ?Post
    {
        return $this->em->getRepository(Post::class)->find($id);
    }
}
