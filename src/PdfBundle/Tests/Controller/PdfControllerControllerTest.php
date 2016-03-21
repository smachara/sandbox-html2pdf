<?php

namespace PdfBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PdfControllerControllerTest extends WebTestCase
{
    public function testPrint()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/print');
    }

    public function testPreview()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/preview');
    }

}
