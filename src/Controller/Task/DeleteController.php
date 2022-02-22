<?php

declare(strict_types=1);

namespace App\Controller\Task;

use App\Entity\Task;
use App\UseCase\Task\Delete\DeleteCommand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    #[IsGranted(subject: 'task', statusCode: 404)]
    #[Route('/tasks/{id}/delete', name: 'task_delete')]
    public function deleteTaskAction(Task $task, MessageBusInterface $bus): Response
    {
        $bus->dispatch(new DeleteCommand($task));

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
