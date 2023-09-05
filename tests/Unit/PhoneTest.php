<?php

namespace Tests\Unit;

use Foxentry\ApiClient;
use Foxentry\Response;
use PHPUnit\Framework\TestCase;
use Tests\Config;

/**
 * Class PhoneTest
 *
 * PHPUnit test case for Phone number validation using Foxentry API.
 */
class PhoneTest extends TestCase
{
    /**
     * @var ApiClient $api Foxentry API client.
     */
    private ApiClient $api;

    /**
     * PhoneTest constructor.
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
     * Test phone number validation.
     */
    public function testValidatePhone()
    {
        // Input query for phone number validation.
        $query = [
            "numberWithPrefix" => "+420607123456"
        ];

        // Perform phone number validation.
        $response = $this->api->phone->validate($query);
        $result = $response->result();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertNotEmpty($result->data);
    }
}