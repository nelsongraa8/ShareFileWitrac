<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginFormTest extends WebTestCase
{
    public function testListFile(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Archivos');
    }

    public function testMyListFile(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/mylistfile');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Mis Archivos');
    }

    public function testLogout(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/logout');

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

    public function testSubmissionFile()
    {
        $client = static::createClient();
        $client->request('GET', '/formfile');

        $this->assertResponseIsSuccessful();

        $client->submitForm('Submit', [
            'form_file[name]' => 'title test ' . rand(99999, 99999999999),
            'form_file[description]' => 'description test ' . rand(99999, 99999999999),
            'form_file[file]' => dirname(__DIR__).'/public/images/foto.jpg'
        ]);

        $this->assertResponseRedirects();

        $client->followRedirect();

        $this->assertSelectorTextContains('h1', 'Archivos');
    }
}
