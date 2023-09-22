<?php

namespace Tests\Unit\Email;

use Foxentry\Response;
use Tests\Base;

/**
 * Class EmailTest
 *
 * PHPUnit test case for Email validation and search using Foxentry API.
 */
class EmailSearchTest extends Base
{
    /**
     * Test valid email search.
     */
    public function testSearchResults()
    {
        // Input string for email search.
        $input = 'info@';

        $options = [
            "resultsLimit" => 5
        ];

        // Perform email search.
        $response = $this->api->email->setOptions($options)->search($input);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($result);
    }
}
