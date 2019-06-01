<?php

namespace App\ReadModel\Auth;

use App\Entity\User\ConfirmToken;
use App\Entity\User\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class UserRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct()
    {
        $this->em = app()->get(EntityManager::class);
        $this->repo = $this->em->getRepository(User::class);
    }

    public function getByEmail(string $email): User
    {
        /** @var User $user */
        if (!$user = $this->repo->findOneBy(['email' => $email])) {
            throw new EntityNotFoundException('User is not found.');
        }
        return $user;
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
        $this->save();
    }

    public function save(): void
    {
        $this->em->flush();
    }
}