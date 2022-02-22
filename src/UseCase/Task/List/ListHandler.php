<?php

declare(strict_types=1);

namespace App\UseCase\Task\List;

use App\Repository\TaskRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ListHandler
{
    public function __construct(private TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function __invoke(ListQuery $query): mixed
    {
        return $this->taskRepository->findBy(
            $query->getCriteria(),
            $query->getOrderBy(),
            $query->getOffset(),
            $query->getLimit()
        );
    }
}
