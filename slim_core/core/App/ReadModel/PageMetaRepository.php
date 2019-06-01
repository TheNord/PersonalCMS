<?php

namespace App\ReadModel;

use App\Entity\PageMeta;
use App\Entity\Settings;
use Doctrine\ORM\EntityManager;

class PageMetaRepository
{
    private $em;
    private $repo;

    public function __construct()
    {
        $this->em = app()->get(EntityManager::class);
        $this->repo = $this->em->getRepository(PageMeta::class);
    }

    public function changeMetaDate($page, $title, $description, $keywords)
    {
        /** @var PageMeta $setting */
        $meta = $this->find($page);

        $meta->setTitle($title);
        $meta->setDescription($description);
        $meta->setKeywords($keywords);

        $this->em->persist($meta);
        $this->em->flush();
    }

    public function find(string $page): PageMeta
    {
        return $this->repo->findOneByName($page);
    }
}