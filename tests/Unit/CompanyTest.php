<?php

namespace Tests\Unit;

use Foxentry\ApiClient;
use Foxentry\Response;
use PHPUnit\Framework\TestCase;
use Tests\Config;

/**
 * Class CompanyTest
 *
 * PHPUnit test case for Company validation and search using Foxentry API.
 */
class CompanyTest extends TestCase
{
    /**
     * @var ApiClient $api Foxentry API client.
     */
    private ApiClient $api;

    /**
     * CompanyTest constructor.
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
     * Test company validation with correction.
     */
    public function testValidateCompanyWithCorrection()
    {
        // Input query for company validation.
        $query = [
            "name" => "Avantro"
        ];

        // Perform company validation.
        $response = $this->api->company->validate($query);
        $result = $response->result();
        $resultCorrected = $response->resultCorrected();

        // Assertions.
        $this->assertEquals("invalidWithCorrection", $result->proposal);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertFalse($result->isValid);
        $this->assertNotEmpty($resultCorrected->data->name);
    }

    /**
     * Test company search.
     */
    public function testSearchCompany()
    {
        // Input query for company search.
        $query = [
            "type" => "name",
            "value" => "Web"
        ];

        // Perform company search.
        $response = $this->api->company->search($query);
        $result = $response->result();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertGreaterThan(0, $response->response()->resultsCount);
        $this->assertNotEmpty($result[0]->data);
    }

    /**
     * Test company retrieval.
     */
    public function testGetCompany()
    {
        // Input query for company retrieval.
        $query = [
            "country" => "CZ",
            "registrationNumber" => "04997476"
        ];

        // Perform company retrieval.
        $response = $this->api->company->get($query);
        $result = $response->result();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertNotEmpty($result[0]->data);
    }
}