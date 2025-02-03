<?php

namespace App\Tests;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Panther\PantherTestCase;

class BaseTestCase extends PantherTestCase {

    // URL
    const CREATE_PRODUCT_URL = '/product';
    const SHOW_PRODUCTS_URL = '/products';


    // Test settings functions
    protected function initCrawler(): Crawler {
        $client = static::createPantherClient();
        $client->manage()->window()->maximize();
        return $client->request('GET', self::SHOW_PRODUCTS_URL);
    }

    // Global functions
    protected function clickLinkAndGetCrawler($crawler, string $linkText): Crawler {
        $link = $crawler->selectLink($linkText)->link();
        return $this->getClient()->request('GET', $link->getUri());
    }
}
