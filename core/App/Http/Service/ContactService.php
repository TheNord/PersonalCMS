<?php

namespace App\Http\Service;

use App\Entity\Contact;
use Doctrine\ORM\EntityManager;
use Slim\Container;
use Swift_Message;

class ContactService
{
    private $em;
    private $session;
    private $mailer;
    private $adminEmail;
    private $view;
    
    public function __construct(Container $container)
    {
        $this->em = $container->get(EntityManager::class);
        $this->session = $container->get('session');
        $this->view = $container->get('view');
        $this->mailer = $container->get('mailer');
        $this->adminEmail = $container->get('personal')['email'];
    }

    public function sending($data)
    {
        // minimal spam security filter, can add recaptcha and remove this
        $time = $this->session->get('contact_time');

        if (date('H:i:s') > $time) {
            $this->session->set('contact_time', date('H:i:s', strtotime('+10 minutes')));
        } elseif (date('H:i:s') < $time) {
            $this->session->setFlash('status', 'You have recently sent a message, please wait!');
            return null;
        }

        // sending a message by mail
        $this->sendMail($data);

        // save message to database
        $this->store($data);

        $this->session->setFlash('status', 'You message successfully sent!');
    }

    public function sendMail($data)
    {
        // Create a message
        $message = (new Swift_Message('Wonderful Subject'))
            ->setFrom($data['email'])
            ->setTo($this->adminEmail)
            ->setBody($this->view->fetch('mail/contact.html.twig', [
                'data' => $data
            ]), 'text/html')
        ;

        // Send the message
        $this->mailer->send($message);
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