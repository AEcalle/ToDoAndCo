<?php

declare(strict_types=1);

namespace App\Controller\Task;

use App\MessageBus\QueryBus;
use App\UseCase\Task\List\ListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    #[Route('/tasks', name: 'task_list')]
    public function listAction(QueryBus $query): Response
    {
        return $this->render('task/list.html.twig', [
            'tasks' => $query->query(new ListQuery())
        ]);
    }
}
