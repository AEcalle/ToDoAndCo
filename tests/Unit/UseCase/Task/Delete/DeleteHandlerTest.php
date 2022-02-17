<?php

declare(strict_types=1);

namespace App\Tests\Unit\Usecase\Task\Delete;

use App\Repository\TaskRepository;
use App\UseCase\Task\Delete\DeleteCommand;
use App\UseCase\Task\Delete\DeleteHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DeleteHandlerTest extends KernelTestCase
{
    public function testInvoke()
    {
        self::bootKernel();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->findOneBy([]);
        $id = $task->getId();
        $deleteHandler = new DeleteHandler($entityManager);

        $deleteHandler->__invoke(new DeleteCommand($task));

        self::assertNull($taskRepository->find($id));
    }
}
