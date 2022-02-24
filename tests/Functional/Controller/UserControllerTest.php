<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class UserControllerTest extends WebTestCase
{
    use \App\Tests\Functional\DataProviderTrait;
    use \App\Tests\Functional\SecurityTrait;

    /**
     * @dataProvider usersUri
     */
    public function testRedirectIfNotLogged(string $uri): void
    {
        $this->RedirectIfNotLogged($uri);
    }

    /**
     * @dataProvider usersUri
     */
    public function testForbiddenAccess(string $uri): void
    {
        $client = $this->login($this->getUserByRoles('ROLE_USER'));

        $client->request('GET', $uri);

        self::assertResponseStatusCodeSame(403);
    }

    public function testList(): void
    {
        $repository = static::getContainer()->get(UserRepository::class);
        $nbItems = $repository->count([]);

        $client = $this->login($this->getUserByRoles());
        $crawler = $client->request('GET', '/users');

        self::assertResponseIsSuccessful();
        self::assertCount($nbItems, $crawler->filter('.user'));
    }

    public function testCreate(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        $nbUsers = $userRepository->count([]);

        $client = $this->login($this->getUserByRoles());
        $crawler = $client->request('GET', '/users/create');

        self::assertResponseIsSuccessful();

        $form = $crawler->filter('form[name=user]')->form([
            'user[username]' => '',
            'user[password][first]' => '',
            'user[password][second]' => '',
            'user[email]' => '',
            'user[roles]' => 'ROLE_USER',
        ]);
        $crawler = $client->submit($form);

        self::assertTrue(3 == $crawler->filter('.invalid-feedback')->count());
        self::assertResponseStatusCodeSame(422);

        $form = $crawler->filter('form[name=user]')->form([
            'user[username]' => 'Username',
            'user[password][first]' => 'Password',
            'user[password][second]' => 'Password',
            'user[email]' => 'email@email.com',
            'user[roles]' => 'ROLE_USER',
        ]);
        $client->submit($form);
        $crawler = $client->followRedirect();

        self::assertCount($nbUsers + 1, $crawler->filter('.user'));
    }

    public function testEdit(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        $id = $userRepository->findOneBy([])->getId();

        $client = $this->login($this->getUserByRoles());
        $crawler = $client->request('GET', '/users/'.$id.'/edit');

        $form = $crawler->filter('form[name=user]')->form([
            'user[username]' => '',
            'user[password][first]' => '',
            'user[password][second]' => '',
            'user[email]' => '',
            'user[roles]' => 'ROLE_USER',
        ]);
        $crawler = $client->submit($form);

        self::assertTrue(3 == $crawler->filter('.invalid-feedback')->count());
        self::assertResponseStatusCodeSame(422);

        $form = $crawler->filter('form[name=user]')->form([
            'user[username]' => 'ModifiedUsername',
            'user[password][first]' => 'ModifiedPassword',
            'user[password][second]' => 'ModifiedPassword',
            'user[email]' => 'modified@email.com',
            'user[roles]' => 'ROLE_USER',
        ]);
        $client->submit($form);

        self::assertResponseRedirects('/users');
        self::assertEquals('ModifiedUsername', $userRepository->find($id)->getUsername());
        self::assertEquals('modified@email.com', $userRepository->find($id)->getEmail());
    }
}
