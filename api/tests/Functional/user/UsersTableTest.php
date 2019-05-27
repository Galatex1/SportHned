<?php

namespace Tests\Functional;

class UsersTableTest extends BaseTestCase
{
    /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    public function testGetAllUsers()
    {
        $response = $this->runApp('GET', '/user/all');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('galatex', (string)$response->getBody());
        $this->assertNotContains('gtex', (string)$response->getBody());
    }
}
