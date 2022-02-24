<?php

declare(strict_types=1);

namespace App\Controller\Task;

use App\Entity\Task;
use App\Form\TaskType;
use App\UseCase\Task\Register\RegisterCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractController
{
    #[Route('/tasks/create', name: 'task_create')]
    public function createAction(Request $request, MessageBusInterface $bus): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bus->dispatch(new RegisterCommand($task));

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->renderForm('task/create.html.twig', [
                'form' => $form,
        ]);
    }
}
