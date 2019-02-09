<?php

namespace App\ReadModel\Auth;

use App\Entity\User\ConfirmToken;
use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class UserRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(User::class);
        $this->em = $em;
    }

    public function hasByEmail(string $email): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.email = :email')
                ->setParameter(':email', $email)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function getByEmail(string $email): User
    {
        /** @var User $user */
        if (!$user = $this->repo->findOneBy(['email' => $email])) {
            throw new EntityNotFoundException('User is not found.');
        }
        return $user;
    }

    public function getByToken(string $token): User
    {
        /** @var User $user */
        if (!$user = $this->repo->findOneBy(['confirmToken.token' => $token])) {
            throw new EntityNotFoundException('Invalid token or user has already been activated.');
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