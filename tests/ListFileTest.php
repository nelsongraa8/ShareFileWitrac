<?php

namespace App\Functional\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListFileTest extends WebTestCase
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
}
