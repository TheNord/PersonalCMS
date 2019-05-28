<?php

namespace Framework\Helpers;

use Framework\Contracts\Events\AggregateRoot;
use Psr\Container\ContainerInterface;

/**
 * Обработчик событий
 * Слушатели и события задаются в настройках events
 */
class EventDispatcher
{
    private $container;
    private $listeners;


    public function __construct(ContainerInterface $container, array $listeners)
    {
        $this->container = $container;
        $this->listeners = $listeners;
    }

    // Получаем класс который реализует интерфейс AggregateRoot (например User)
    public function dispatch(AggregateRoot ...$roots): void
    {
        // получаем все события созданные классом
        $events = array_reduce($roots, function (array $events, AggregateRoot $root) {
            return array_merge($events, $root->releaseEvents());
        }, []);

        // обрабатываем события
        $this->processing(...$events);
    }

    public function processing(...$events): void
    {
        foreach ($events as $event) {
            $this->dispatchEvent($event);
        }
    }

    private function dispatchEvent($event): void
    {
        $eventName = \get_class($event);
        if (array_key_exists($eventName, $this->listeners)) {
            foreach ($this->listeners[$eventName] as $listenerClass) {
                // получаем слушателей из контейнера
                $listener = $this->resolveListener($listenerClass);
                // вызываем метод __invoke (прим. отправка письма с токеном в CreatedListener)
                $listener($event);
            }
        }
    }

    private function resolveListener($listenerClass): callable
    {
        return $this->container->get($listenerClass);
    }
}