<?php

namespace App\Console\Command;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixtureCommand extends Command
{
    private $em;
    private $path;

    public function __construct(EntityManagerInterface $em, string $path)
    {
        parent::__construct();
        $this->em = $em;
        $this->path = $path;
    }

    protected function configure(): void
    {
        $this
            ->setName('fixtures:load')
            ->setDescription('Load fixtures')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Loading fixtures</comment>');

        // создаем объект лоадера фикстур
        $loader = new Loader();
        // загружаем фикстуры из переданной в контейнере (фабрики Infrastructure\App\Console\Command\FixtureCommandFactory) директории
        $loader->loadFromDirectory($this->path);

        // создаем класс, ответственный за выполнение фикстуры данных
        $executor = new ORMExecutor($this->em, new ORMPurger());

        // устанавливаем логгер (вывод данных)
        $executor->setLogger(function ($message) use ($output) {
            // выводим данные в консоль
            $output->writeln($message);
        });

        // прокидываем фикстуры и выполняем их (все будет обернуто в транзакцию для надежности)
        $executor->execute($loader->getFixtures());

        // сообщаем о завершении
        $output->writeln('<info>Done!</info>');
    }
}
