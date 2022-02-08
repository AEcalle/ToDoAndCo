<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class TaskControllerTest extends WebTestCase
{
    use \App\Tests\Functional\DataProviderTrait;
    use \App\Tests\Functional\SecurityTrait;

    /**
     * @dataProvider tasksUri
     */
    public function testRedirectIfNotLogged(string $uri): void
    {
        $this->RedirectIfNotLogged($uri);
    }

    public function testList(): void
    {
        $repository = static::getContainer()->get(TaskRepository::class);
        $nbItems = $repository->count([]);

        $client = $this->login($this->getUserByRoles());
        $crawler = $client->request('GET', '/tasks');

        self::assertResponseIsSuccessful();
        self::assertCount($nbItems, $crawler->filter('.task'));
    }

    public function testCreate(): void
    {
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $nbTasks = $taskRepository->count([]);

        $client = $this->login($this->getUserByRoles());
        $crawler = $client->request('GET', '/tasks/create');

        self::assertResponseIsSuccessful();

        $form = $crawler->filter('form[name=task]')->form([
            'task[title]' => '',
            'task[content]' => '',
        ]);
        $crawler = $client->submit($form);
        self::assertTrue($crawler->filter('.invalid-feedback')->count() == 2);


        $form = $crawler->filter('form[name=task]')->form([
            'task[title]' => 'Title',
            'task[content]' => 'Content',
        ]);
        $client->submit($form);
        $crawler = $client->followRedirect();

        self::assertCount($nbTasks + 1, $crawler->filter('.tasks'));
    }

    public function testEdit(): void
    {
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $id = $taskRepository->findOneBy([])->getId();

        $client = $this->login($this->getUserByRoles());
        $crawler = $client->request('GET', '/tasks/'.$id.'/edit');

        $form = $crawler->filter('form[name=task]')->form([
            'task[title]' => '',
            'task[content]' => '',
        ]);
        $crawler = $client->submit($form);
        self::assertTrue($crawler->filter('.invalid-feedback')->count() == 2);

        $form = $crawler->filter('form[name=task]')->form([
            'task[title]' => 'ModifiedTitle',
            'task[content]' => 'ModifiedContent',
        ]);
        $client->submit($form);

        self::assertResponseRedirects('/tasks');
        self::assertEquals('ModifiedTitle', $taskRepository->find($id)->getTitle());
        self::assertEquals('ModifiedContent', $taskRepository->find($id)->getContent());
    }

    public function testToogle(): void
    {
        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $task = $taskRepository->findOneBy([]);
        $isDone = $task->isDone();

        $client = $this->login($this->getUserByRoles());
        $client->request('GET', '/tasks/'.$task->getId().'/toogle');

        self::assertResponseRedirects('/tasks');
        self::assertEquals(!$isDone, $taskRepository->find($task->getId())->isDone());
    }

    public function testDeleteSuccess(): void
    {
        $client = static::createClient();

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $id = $taskRepository->findOneBy([])->getId();

        $this->login($this->getUserByRoles());
        $crawler = $client->request('GET', '/tasks');

        $form = $crawler->selectButton('delete-task-'.$id);

        $client->submit($form);

        self::assertResponseRedirects('/tasks');
        self::assertNull($taskRepository->find($id));  
    }

    public function testDeleteFailureMissingToken(): void
    {
        $client = static::createClient();

        $taskRepository = static::getContainer()->get(TaskRepository::class);
        $id = $taskRepository->findOneBy([])->getId();

        $this->login($this->getUserByRoles());

        $client->request('POST', '/tasks/'.$id.'/delete');

        self::assertResponseRedirects('/tasks');
        self::assertNotNull($taskRepository->find($id));
    }
}
