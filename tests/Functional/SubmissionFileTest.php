<?php

namespace App\Functional\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SubmissionFileTest extends WebTestCase
{
    public function testSubmissionFile()
    {
        $client = static::createClient();

        $client->request('GET', '/formfile');

        $this->assertResponseIsSuccessful();

        $client->submitForm('Submit', [
            'form_file[name]' => 'title test ' . rand(99999, 99999999999),
            'form_file[description]' => 'description test ' . rand(99999, 99999999999),
            'form_file[file]' => dirname(__DIR__, 2) . '/public/images/foto.jpg'
        ]);

        $this->assertResponseRedirects();

        $client->followRedirect();

        $this->assertSelectorTextContains('h1', 'Archivos');
    }
}
