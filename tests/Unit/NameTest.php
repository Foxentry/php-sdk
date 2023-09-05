<?php

namespace Tests\Unit;

use Foxentry\ApiClient;
use Foxentry\Response;
use PHPUnit\Framework\TestCase;
use Tests\Config;

/**
 * Class NameTest
 *
 * PHPUnit test case for Name validation using Foxentry API.
 */
class NameTest extends TestCase
{
    /**
     * @var ApiClient $api Foxentry API client.
     */
    private ApiClient $api;

    /**
     * NameTest constructor.
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
     * Test name validation with suggestions.
     */
    public function testValidateName()
    {
        // Input query for name validation.
        $query = [
            "name" => "Pawel"
        ];

        // Perform name validation.
        $response = $this->api->name->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals("validWithSuggestion", $result->proposal);
        $this->assertNotEmpty($response->getSuggestions());
    }
}