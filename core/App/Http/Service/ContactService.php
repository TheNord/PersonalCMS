<?php

namespace App\Http\Service;

use App\Entity\Contact;
use App\Entity\Post\Post;
use Doctrine\ORM\EntityManager;
use Slim\Container;

class ContactService
{
    private $em;
    private $session;
    
    public function __construct(Container $container)
    {
        $this->em = $container->get(EntityManager::class);
        $this->session = $container->get('session');
    }

    public function sending($data)
    {
        // minimal spam security filter, can add recaptcha and remove this
        $time = $this->session->get('contact_time');

        if (date('H:i:s') > $time) {
            $this->session->set('contact_time', date('H:i:s', strtotime('+15 minutes')));
        } elseif (date('H:i:s') < $time) {
            throw new \Exception("You have recently sent a message, please wait");
        }

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