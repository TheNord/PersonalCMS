<?php

namespace App\ReadModel;

use App\Entity\Post\Post;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Slim\Container;
use App\Entity\Contact;

class ContactReadRepository
{
    private $em;

    public function __construct()
    {
        $this->em = app()->get(EntityManager::class);
    }

    public function all()
    {
        $contacts = $this->em->getRepository(Contact::class)->findAll();
        
        return $contacts;
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