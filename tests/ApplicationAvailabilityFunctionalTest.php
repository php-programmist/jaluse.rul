<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        
        
        $this->assertResponseIsSuccessful("Wrong url is $url");
    }
    
    public function testPageIsNotFound()
    {
        $client = self::createClient();
        $client->request('GET', '/abrakadabra/');
        
        $this->assertResponseStatusCodeSame(404);
    }
    
    public function testPageIsRedirect()
    {
        $client = self::createClient();
        $client->request('GET', '/admin/');
        
        $this->assertResponseRedirects('/login');
    }
    
    
    public function urlProvider()
    {
        yield ['/'];
        yield ['/zhalyuzi/'];
        yield ['/zhalyuzi/vertikalnye/tkanevye/avrora-persikovyj/'];
        yield ['/api/calc/getInitData'];
        yield ['/api/calc/getProducts'];
        
    }
}