<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListingControlerTest extends WebTestCase
{
    /*
    public function testSomething()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello World');
    }
    */

    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url) {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider() {
        return [
            ['/'],
            ['/base.html.twig']
        ];
    }

    public function testAccessNewTask() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $linkCrawler = $crawler->filter('#new');
        $link = $linkCrawler->selectLink('')->link();

        $crawler = $client->click($link);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Créer une tâche', $crawler->filter('h2')->text());
    }

    public function testListingCreation() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $linkCrawler = $crawler->filter('#newlist');
        $form = $linkCrawler->selectButton('')->form();

        $form['name']->setValue('Listing de test');

        $crawler = $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect());

        // var_dump($crawler->html());
        $crawler = $client->followRedirect();

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Créée avec succès', $crawler->filter('div')
        ->text($default = null, $normalizeWhitespace = true));
        $this->assertContains(
            'Listing de test',
            //$crawler->filter('a)->last()->text()
            $client->getResponse()->getContent()
        );

        
    }
}
