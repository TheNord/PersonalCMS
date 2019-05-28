<?php

namespace App\Console\Command;

use App\Service\FileManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class CacheClearCommand extends Command
{
    private $paths;
    private $files;

    public function __construct(array $paths, FileManager $files)
    {
        $this->paths = $paths;
        $this->files = $files;
        parent::__construct();
    }

    // конфигурируем команду
    protected function configure(): void
    {
        $this
            ->setName('cache:clear')
            ->setDescription('Clear cache')
            // добавляем аргумент (для выбора пути)
            ->addArgument('alias', InputArgument::OPTIONAL, 'The alias of available paths.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // информационная строка
        $output->writeln('<comment>Clearing cache</comment>');

        // получаем аргумент для ввода пути
        $alias = $input->getArgument('alias');

        // если аргумент пуст
        if (empty($alias)) {
            // получаем хелпер
            $helper = $this->getHelper('question');
            // выводим доступные опции (пути), добавляем all (для удаления всех путей)
            $options = array_merge(['all'], array_keys($this->paths));
            // создаем объект задающий вопрос - выберите путь, указывая варианты, и дефолтный выбор 0 (all)
            $question = new ChoiceQuestion('Choose path', $options, 0);
            // спрашиваем пользователя
            $alias = $helper->ask($input, $output, $question);
        }

        // если выбраны все то выбираем массив путей
        if ($alias === 'all') {
            $paths = $this->paths;
        } else {
            // если указанного пути нет в массиве выводим ошибку
            if (!array_key_exists($alias, $this->paths)) {
                throw new \InvalidArgumentException('Unknown path alias "' . $alias . '"');
            }
            // указываем в качестве пути выбранный пользователем путь
            $paths = [$alias => $this->paths[$alias]];
        }

        // проходим циклом по полученным путям выбранным пользователем
        foreach ($paths as $path) {
            // если такая папка существует
            if ($this->files->exists($path)) {
                // удаляем её
                $output->writeln('Remove ' . $path);
                $this->files->delete($path);
            } else {
                // если не существует пропускаем
                $output->writeln('Skip ' . $path);
            }
        }

        // информация о завершении
        $output->writeln('<info>Done!</info>');
    }
}
