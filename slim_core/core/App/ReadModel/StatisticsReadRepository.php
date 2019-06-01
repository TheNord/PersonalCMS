<?php

namespace App\ReadModel;

use Carbon\Carbon;
use App\Entity\Contact;
use App\Entity\Statistics;
use Doctrine\ORM\EntityManager;

class StatisticsReadRepository
{
    private $em;

    public function __construct()
    {
        $this->em = app()->get(EntityManager::class);
    }

    public function getAllStatistics()
    {
        $stats = $this->em->getRepository(Statistics::class)->findAll();
        return $stats;
    }

    public function getTodayStats()
    {
        $repository = $this->em->getRepository(Statistics::class);
        $lastDay = $repository->findOneBy([], ['id' => 'DESC']);
        return $lastDay;
    }

    public function addView()
    {
        $lastDay = $this->getTodayStats();

        if ($lastDay && $lastDay->getDate()->format('Y-m-d') === Carbon::now()->format('Y-m-d')) {
            $lastDay->incrementView();
            $this->em->flush();
            return true;
        }    

        $view = new Statistics(
            \DateTimeImmutable::createFromMutable(new \DateTime()),
            1
        );

        $this->em->persist($view);
        $this->em->flush();
    }
}