<?php


use App\Console\Command\FixtureCommand;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

return [

    // doctrine configuration
    EntityManager::class => function (ContainerInterface $container): EntityManager {
        $config = Setup::createAnnotationMetadataConfiguration(
            $container['settings']['doctrine']['metadata_dirs'],
            $container['settings']['doctrine']['dev_mode']
        );

        $config->setMetadataDriverImpl(
            new AnnotationDriver(
                new AnnotationReader,
                $container['settings']['doctrine']['metadata_dirs']
            )
        );

        $config->setMetadataCacheImpl(
            new FilesystemCache(
                $container['settings']['doctrine']['cache_dir']
            )
        );

        return EntityManager::create(
            $container['settings']['doctrine']['connection'],
            $config
        );
    },

    // fixture command
    FixtureCommand::class => function (ContainerInterface $container) {
        return new FixtureCommand(
            $container->get(EntityManagerInterface::class),
            'db/fixtures'
        );
    },

];