<?php

declare(strict_types=1);

namespace App\Controller\Task;

use App\Entity\Task;
use App\UseCase\Task\Toggle\ToggleCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ToggleController extends AbstractController
{
    #[Route('/tasks/{id}/toggle', name: 'task_toggle')]
    public function toggleTaskAction(Task $task, MessageBusInterface $bus): Response
    {
        $bus->dispatch(new ToggleCommand($task));

        $this->addFlash('success', sprintf(
            $task->isDone() === true ? 
            'La tâche %s a bien été marquée comme faite.' 
            : 'La tâche %s a bien été marquée comme non terminée.', 
            $task->getTitle()
        ));

        return $this->redirectToRoute('task_list');
    }
}
