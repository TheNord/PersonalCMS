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
        $contacts = $this->em->getRepository(Contact::class)->findBy([], ['id' => 'DESC']);
        return $contacts;
    }

    public function delete(int $id)
    {
        $contact = $this->find($id);
        $this->em->remove($contact);
        $this->em->flush();
    }

    public function find(int $id): Contact
    {
        return $this->em->getRepository(Contact::class)->find($id);
    }
}