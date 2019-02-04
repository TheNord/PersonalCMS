<?php

namespace App\Http\Service;

use App\Entity\Contact;
use App\Entity\Post\Post;
use Doctrine\ORM\EntityManager;
use Slim\Container;

class ContactService
{
    private $em;
    
    public function __construct(Container $container)
    {
        $this->em = $container->get(EntityManager::class);
    }

    public function sending($data)
    {
        // sending a message by mail
        // ...

        // save message to database
        $this->store($data);
    }
    
    public function store($data)
    {
        $message = new Contact(
            \DateTimeImmutable::createFromMutable(new \DateTime()),
            $data['name'],
            $data['email'],
            $data['message']
        );

        $this->em->persist($message);
        $this->em->flush();
    }
}