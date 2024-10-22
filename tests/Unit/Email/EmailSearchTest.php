<?php

declare(strict_types=1);

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
    public function testSearchResults(): void
    {
        // Input string for email search.
        $input = 'info@';

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 5,
        ];

        // Perform email search.
        $response = $this->api->email()->setOptions($options)->search($input);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($result);
    }

    /**
     *  Test email search when the input parameter is specified as the entire query.
     */
    public function testQueryInput(): void
    {
        // Query that will be sent to the API for validation.
        $query = [
            "value" => "info@",
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 5,
        ];

        // Perform email validation.
        $response = $this->api->email()->setOptions($options)->search($query);

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
    }
}
