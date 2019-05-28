<?php

namespace App\Http\Service;

use App\Entity\Contact;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Swift_Message;

class ContactService
{
    private $em;
    private $mailer;
    private $adminEmail;

    public function __construct(ContainerInterface $container)
    {
        $this->em = $container->get(EntityManager::class);
        $this->mailer = $container->get('mailer');
        $this->adminEmail = $container->get('settings')['email'];
    }

    /**
     * Minimal spam security filter, can add recaptcha and remove this
     *
     * @return boolean
     */
    public function checkSpam(): bool
    {
        $time = session()->get('contact_time');

        if (date('H:i:s') > $time) {
            session('contact_time', date('H:i:s', strtotime('+10 minutes')));
            return false;
        } elseif (date('H:i:s') < $time) {
            return true;
        }

        return null;
    }


    public function sending($data)
    {
        // sending a message by mail
        $this->sendMail($data);

        // save message to database
        $this->store($data);
    }

    public function sendMail($data)
    {
        // Create a message
        $message = (new Swift_Message('Wonderful Subject'))
            ->setFrom($data['email'])
            ->setTo($this->adminEmail)
            ->setBody(view('mail/contact', [
                'data' => $data
            ]), 'text/html');

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