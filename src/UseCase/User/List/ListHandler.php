<?php

declare(strict_types=1);

namespace App\UseCase\User\List;

use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[AsMessageHandler]
final class ListHandler
{
    public function __construct(private UserRepository $userRepository, private TagAwareCacheInterface $redisCache)
    {
        $this->userRepository = $userRepository;
        $this->redisCache = $redisCache;
    }

    public function __invoke(ListQuery $query): mixed
    {
        $list = $this->redisCache->get('userLists', function(ItemInterface $item) use ($query) {
            $item->tag(['Users', 'offset'.$query->getOffset(), 'limit'.$query->getLimit()]);
            return $this->userRepository->findBy(
                $query->getCriteria(),
                $query->getOrderBy(),
                $query->getOffset(),
                $query->getLimit()
            );
        });
        return $list;
    }
}
