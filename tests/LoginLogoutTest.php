<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginLogoutTest extends WebTestCase
{
    public function testCreateUser()
    {
        $client = static::createClient();
        $client->request('GET', '/createuser');

        $this->assertResponseIsSuccessful();

        $userRand = 'user' . rand(999999, 99999999999999999) . '@mail.com';
        $client->submitForm('Submit', [
            'create_user[email]' => $userRand,
            'create_user[password]' => '123'
        ]);

        $this->assertResponseRedirects();

        $client->followRedirect();

        $this->assertSelectorTextContains('h1', 'Archivos');
    }

    public function testLoginUser()
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();

        $client->submitForm('Sign in', [
            'email' => 'user@mail.com',
            'password' => '123'
        ]);

        $this->assertResponseRedirects();

        $client->followRedirect();

        $this->assertSelectorTextContains('h1', 'Formulario de Archivo');
    }

    public function testLogout(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/logout');

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Archivos');
    }
}
