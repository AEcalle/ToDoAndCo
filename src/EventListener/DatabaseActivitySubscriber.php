<?php

declare(strict_types=1);

namespace App\EventListener;

use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class DatabaseActivitySubscriber  implements EventSubscriberInterface
{
    public function __construct(private TagAwareCacheInterface $redisCache)
    {
        $this->redisCache = $redisCache;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postRemove,
            Events::postUpdate,
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->redisCache->invalidateTags([str_replace('App\\Entity\\','',$args->getObject()::class).'s']);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->redisCache->invalidateTags([str_replace('App\\Entity\\','',$args->getObject()::class).'s']);
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $this->redisCache->invalidateTags([str_replace('App\\Entity\\','',$args->getObject()::class).'s']);
    }
}