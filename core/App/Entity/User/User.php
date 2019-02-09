<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\Entity\User\Event\UserConfirmed;
use App\Entity\User\Event\UserCreated;
use Doctrine\ORM\Mapping as ORM;
use Framework\Contracts\Events\AggregateRoot;
use Framework\Traits\Events\EventTrait;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="users", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"email"})
 * })
 */
class User implements AggregateRoot
{
    use EventTrait;

    private const STATUS_WAIT = 'wait';
    private const STATUS_ACTIVE = 'active';

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
    private $email;
    /**
     * @ORM\Column(type="string", name="password")
     */
    private $password;
    /**
     * @var ConfirmToken
     * @ORM\Embedded(class="ConfirmToken", columnPrefix="confirm_token_")
     */
    private $confirmToken;
    /**
     * @ORM\Column(type="string", length=16)
     */
    private $status;

    public function __construct(
        \DateTimeImmutable $date,
        string $email,
        string $password,
        ConfirmToken $confirmToken
    )
    {
        $this->date = $date;
        $this->email = $email;
        $this->password = $password;
        $this->confirmToken = $confirmToken;
        $this->status = self::STATUS_WAIT;
        $this->recordEvent(new UserCreated($this->email, $this->confirmToken));
    }

    public function confirmSignup(string $token, \DateTimeImmutable $date): void
    {
        if ($this->isActive()) {
            throw new \DomainException('User is already active.');
        }
        $this->confirmToken->validate($token, $date);
        $this->status = self::STATUS_ACTIVE;
        $this->confirmToken = null;
        $this->recordEvent(new UserConfirmed($this->id));
    }

    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getConfirmToken(): ?ConfirmToken
    {
        return $this->confirmToken;
    }

    /**
     * @ORM\PostLoad()
     */
    public function checkEmbeds(): void
    {
        if ($this->confirmToken->isEmpty()) {
            $this->confirmToken = null;
        }
    }
}
