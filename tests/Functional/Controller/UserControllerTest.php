<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class UserControllerTest
 * @package App\Tests\Functional\Controller
 */
class UserControllerTest extends WebTestCase
{
    public function test___index()
    {
        $client = static::createClient();

        $client->request('GET', '/api/users');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}