<?php

namespace App\ReadModel;

use App\Entity\Post\Post;
use App\Entity\Settings;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Slim\Container;
use App\Entity\Contact;

class SettingsRepository
{
    private $em;
    private $repo;

    public function __construct()
    {
        $this->em = app()->get(EntityManager::class);
        $this->repo = $this->em->getRepository(Settings::class);
    }

    public function changeValue(string $name, string $value)
    {
        /** @var Settings $setting */
        $setting = $this->find($name);
        $setting->setValue($value);

        $this->em->persist($setting);
        $this->em->flush();
    }

    public function find(string $name): Settings
    {
        return $this->repo->findOneByName($name);
    }
}