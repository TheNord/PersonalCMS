<?php

declare (strict_types = 1);

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Framework\Contracts\Events\AggregateRoot;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="users", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"email"})
 * })
 */
class User
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="string", name="password")
     */
    private $password;


    public function __construct(
        \DateTimeImmutable $date,
        string $name,
        string $email,
        string $password
    ) {
        $this->date = $date;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
