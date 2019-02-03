<?php

namespace Fixtures;

use App\Entity\Post\Content;
use App\Entity\Post\Meta;
use App\Entity\Post\Post;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class BlogFixture implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        // получаем фейкер
        $faker = \Faker\Factory::create();

        // проходим циклом 50 раз (для создания 50 постов)
        for ($i = 0; $i < 50; $i++) {
            // через конструтор
            $post = new Post(
                // передаем дату
                \DateTimeImmutable::createFromMutable($faker->dateTime),
                // название, обрезая точку на конце
                trim($faker->sentence, '.'),
                // генерируем контент
                new Content(
                    $faker->text(500),
                    $faker->paragraphs(5, true)
                ),
                // генерируем мета данные
                new Meta(
                    trim($faker->sentence, '.'),
                    $faker->text(200)
                )
            );

            // получаем случайно число для комментариев
            $count = random_int(0, 10);
            // проходим циклом создавая нужное количество комментариев
            for ($j = 0; $j < $count; $j++) {
                // добавляем комментарии
                $post->addComment(
                    \DateTimeImmutable::createFromMutable($faker->dateTime),
                    $faker->name,
                    $faker->text(200)
                );
            }

            // помечаем пост на добавление
            $manager->persist($post);
        }

        // добаляем посты и комментарии
        $manager->flush();
    }
}