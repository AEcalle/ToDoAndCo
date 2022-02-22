<?php

declare(strict_types=1);

namespace App\UseCase\Task\Toggle;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ToggleHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager
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
