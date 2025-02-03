<?php

namespace App\Tests;

# Test/Exploration de Panther

class ProductTest extends BaseTestCase {

    public function testNavBarNavigation(): void
    {
        // INIT
        $client = static::createPantherClient();
        $client->manage()->window()->maximize();

        // PROduct PAGE
        $client->request('GET', self::SHOW_PRODUCTS_URL);


        $this->assertSelectorTextContains(".body", "");
    }
}
