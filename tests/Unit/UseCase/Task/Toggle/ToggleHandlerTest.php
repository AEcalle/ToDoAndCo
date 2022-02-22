<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usecase\Task\Toggle;

use App\Repository\TaskRepository;
use App\UseCase\Task\Toggle\ToggleCommand;
use App\UseCase\Task\Toggle\ToggleHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ToggleHandlerTest extends KernelTestCase
{
    public function testInvoke()
    {
        self::bootKernel();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->findOneBy([]);
        $isDone = $task->isDone();
        $toggleHandler = new ToggleHandler($entityManager);

        $toggleHandler->__invoke(new ToggleCommand($task));

        self::assertEquals(!$isDone, $taskRepository->find($task->getId())->isDone());
    }
}
