<?php

declare(strict_types=1);

namespace App\Tests\Functional\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AuthenticationTest extends WebTestCase
{
    public function testAuthenticationSuccess(): void
    {
        $client = self::createClient();

        $crawler = $client->request('GET', '/login');

        self::assertResponseIsSuccessful();

        $form = $crawler->filter('form[name=login_form]')->form([
            '_username' => 'email@email.com',
            '_password' => 'password',
        ]);
        $client->submit($form);

        self::assertResponseStatusCodeSame(302);
    }

    public function testAuthenticationFailure(): void
    {
        $client = self::createClient();

        $crawler = $client->request('GET', '/login');

        self::assertResponseIsSuccessful();

        $form = $crawler->filter('form[name=login_form]')->form([
            '_username' => 'email@email.com',
            '_password' => 'WorngPassword',
        ]);
        $crawler = $client->submit($form);

        self::assertResponseStatusCodeSame(302);

        $client->followRedirect();

        self::assertSelectorTextContains('html', 'Invalid credentials.');
    }
}
