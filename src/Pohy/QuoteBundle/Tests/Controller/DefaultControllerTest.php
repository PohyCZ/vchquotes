<?php

namespace Pohy\QuoteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('html:contains("aldkjhalksdjhg")')->count() > 0);
    }

    // public function testView()
    // {
    // 	$client = static::createClient();

    // 	$crawler = $client->request('GET', '/view/25');

    // 	$this->assertTrue($crawler->filter('html:contains("#25")')->count() > 0);
    // }
}
