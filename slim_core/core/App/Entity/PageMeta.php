<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pages_meta")
 */
class PageMeta
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $keywords;

    public function __construct(string $name, string $title, string $description, string $keywords)
    {
        $this->name = $name;
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getKeywords(): string
    {
        return $this->keywords;
    }

    public function setTitle(string $value): void
    {
        $this->title = $value;
    }

    public function setDescription(string $value): void
    {
        $this->description = $value;
    }

    public function setKeywords(string $value): void
    {
        $this->keywords = $value;
    }
}
