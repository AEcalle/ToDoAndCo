<?php

declare(strict_types=1);

namespace App\Tests\Functional\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AuthenticationTest extends WebTestCase
{
    public function testAuthenticationSuccess(): void
    {
        $client = self::createClient();

        $client->request('GET', '/login');

        self::assertResponseIsSuccessful();

        $client->submitForm('login_form', [
            '_username' => 'email@email.com',
            '_password' => 'password',
        ]);

        self::assertResponseRedirects('/');
    }

    public function testAuthenticationFailure(): void
    {
        $client = self::createClient();

        $client->request('GET', '/login');

        self::assertResponseIsSuccessful();

        $client->submitForm('login_form', [
            '_username' => 'email@email.com',
            '_password' => 'WorngPassword',
        ]);

        self::assertResponseRedirects('/login');
    }

}