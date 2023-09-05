<?php

namespace Unit;

use Foxentry\ApiClient;
use Foxentry\Response;
use PHPUnit\Framework\TestCase;
use Tests\Config;

/**
 * Class LocationTest
 *
 * PHPUnit test case for Location validation and search using Foxentry API.
 */
class LocationTest extends TestCase
{
    /**
     * @var ApiClient $api Foxentry API client.
     */
    private ApiClient $api;

    /**
     * LocationTest constructor.
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
     * Test location validation with correction.
     */
    public function testValidateLocation()
    {
        // Input query for location validation.
        $query = [
            "streetWithNumber" => "Thámova 137",
            "city" => "Praha",
            "zip" => "18600"
        ];

        // Perform location validation.
        $response = $this->api->location->validate($query);
        $result = $response->result();
        $resultCorrected = $response->resultCorrected();

        // Assertions.
        $this->assertEquals("invalidWithCorrection", $result->proposal);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertNotEmpty($resultCorrected->data);
    }

    /**
     * Test location search.
     */
    public function testSearchLocation()
    {
        // Input query for location search.
        $query = [
            "type" => "street",
            "value" => "tha"
        ];

        // Perform location search.
        $response = $this->api->location->search($query);
        $result = $response->result();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertGreaterThan(0, $response->response()->resultsCount);
        $this->assertNotEmpty($result[0]->data);
    }

    /**
     * Test location retrieval.
     */
    public function testGetLocation()
    {
        // Input query for location retrieval.
        $query = [
            "id" => "22349995",
            "country" => "CZ"
        ];

        // Perform location retrieval.
        $response = $this->api->location->setOptions(["idType" => "external"])->get($query);
        $result = $response->result();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertNotEmpty($result[0]->data);
    }

    /**
     * Test location localization.
     */
    public function testLocalizeLocation()
    {
        // Input query for location localization.
        $query = [
            "lat" => 50.0920004,
            "lon" => 14.4527362
        ];

        // Perform location localization.
        $response = $this->api->location->localize($query);
        $result = $response->result();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertGreaterThan(0, $response->response()->resultsCount);
        $this->assertNotEmpty($result[0]->data);
    }
}