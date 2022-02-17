<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\MessageBus\QueryBus;
use App\UseCase\User\List\ListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    #[Route('/users', name: 'user_list')]
    public function listAction(QueryBus $query): Response
    {
        return $this->render('user/list.html.twig', [
            'users' => $query->query(new ListQuery()),
        ]);
    }
}
