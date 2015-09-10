<?php

namespace KeleyLive\CentralBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ExceptionControllerTest extends WebTestCase
{
    public function testShowexception()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showException');
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/show');
    }

}
