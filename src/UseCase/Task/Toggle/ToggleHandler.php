<?php

declare(strict_types=1);

namespace App\UseCase\Task\Toggle;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ToggleHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function __invoke(ToggleCommand $command): void
    {
        $task = $command->getTask();

        $task->toggle(!$task->isDone());
        $this->entityManager->flush();
    }
}
