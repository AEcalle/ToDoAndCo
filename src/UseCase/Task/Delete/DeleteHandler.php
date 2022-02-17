<?php

declare(strict_types=1);

namespace App\UseCase\Task\Delete;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DeleteHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function __invoke(DeleteCommand $command): void
    {
        $task = $command->getTask();

        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }
}
