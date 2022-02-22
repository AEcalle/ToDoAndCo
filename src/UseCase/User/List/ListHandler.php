<?php

declare(strict_types=1);

namespace App\UseCase\User\List;

use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ListHandler
{
    public function __construct(private UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(ListQuery $query): mixed
    {
        return $this->userRepository->findBy(
            $query->getCriteria(),
            $query->getOrderBy(),
            $query->getOffset(),
            $query->getLimit()
        );
    }
}
