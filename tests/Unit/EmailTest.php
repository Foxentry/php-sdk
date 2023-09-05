<?php

namespace Tests\Unit;

use Foxentry\ApiClient;
use Foxentry\Response;
use PHPUnit\Framework\TestCase;
use Tests\Config;

/**
 * Class EmailTest
 *
 * PHPUnit test case for Email validation and search using Foxentry API.
 */
class EmailTest extends TestCase
{
    /**
     * @var ApiClient $api Foxentry API client.
     */
    private ApiClient $api;

    /**
     * EmailTest constructor.
     *
     * @param string $name The name of the test case.
     */
    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->assertNotEmpty(Config::API_KEY, 'You didn\'t set your API key in the \test\Config.php file');
        $this->api = new ApiClient(Config::API_KEY);
    }

    /**
     * Test valid email validation.
     */
    public function testValidateValidEmail()
    {
        // Valid email address for testing.
        $validEmail = 'info@foxentry.com';

        // Perform email validation.
        $response = $this->api->email->validate($validEmail);
        $result = $response->result();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertTrue($result->isValid);
        $this->assertNotEmpty($result->data);
    }

    /**
     * Test invalid email validation.
     */
    public function testValidateInvalidEmail()
    {
        // Invalid email address for testing.
        $invalidEmail = 'info@foxentry,com';

        // Perform email validation.
        $response = $this->api->email->validate($invalidEmail);
        $result = $response->result();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertFalse($result->isValid);
        $this->assertNotEmpty($result->data);
    }

    /**
     * Test valid email search.
     */
    public function testSearchEmail()
    {
        // Input string for email search.
        $input = 'info@';

        // Perform email search.
        $response = $this->api->email->search($input);
        $result = $response->result();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertGreaterThan(0, $response->response()->resultsCount);
        $this->assertNotEmpty($result);
    }
}
