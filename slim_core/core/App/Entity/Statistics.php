<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="statistics")
 */
class Statistics
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable", name="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $views;

    public function __construct(\DateTimeImmutable $date, int $views = 0)
    {
        $this->date = $date;
        $this->views = $views;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function incrementView()
    {
        return $this->views++;
    }

    public function getViewsCount(): int
    {
        return $this->views;
    }
}
