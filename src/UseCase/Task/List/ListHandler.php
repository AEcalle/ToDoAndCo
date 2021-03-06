<?php

declare(strict_types=1);

namespace App\UseCase\Task\List;

use App\Repository\TaskRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[AsMessageHandler]
final class ListHandler
{
    public function __construct(private TaskRepository $taskRepository, private TagAwareCacheInterface $redisCache)
    {
        $this->taskRepository = $taskRepository;
        $this->redisCache = $redisCache;
    }

    public function __invoke(ListQuery $query): mixed
    {
        $list = $this->redisCache->get(
            'tasksList'.http_build_query(
                [
                    $query->getCriteria(),
                    $query->getOrderBy(),
                    $query->getOffset(),
                    $query->getLimit()
                ]
            ), function(ItemInterface $item) use ($query) {
            $item->tag(['Tasks']);
            return $this->taskRepository->findBy(
                $query->getCriteria(),
                $query->getOrderBy(),
                $query->getOffset(),
                $query->getLimit()
            );
        });
        return $list;
    }
}
