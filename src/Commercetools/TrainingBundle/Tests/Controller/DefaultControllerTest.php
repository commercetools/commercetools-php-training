<?php

namespace Commercetools\TrainingBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/training/');

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }
}
