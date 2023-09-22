<?php

namespace Tests\Unit\Location;

use Foxentry\Response;
use Tests\Base;

/**
 * PHPUnit test case for Location data validation
 */
class LocationValidateTest extends Base
{
    /**
     * Test valid location data validation.
     */
    public function testValid()
    {
        // Query parameters for validating location data.
        $query = [
            "streetWithNumber" => "Thámova 137/16",
            "city" => "Praha",
            "zip" => "186 00"
        ];

        // Options that will be sent within the request.
        $options = [
            "dataScope" => "basic",
            "cityFormat" => "minimal",
            "zipFormat" => true
        ];

        // Perform location data validation.
        $response = $this->api->location->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertTrue($result->isValid);
        $this->assertEquals("valid", $result->proposal);
        $this->assertNotEmpty($result->data);
    }

    /**
     * Test invalid location data.
     */
    public function testInvalid()
    {
        // Query parameters for validating location data.
        $query = [
            "streetWithNumber" => "Thámova 123456789",
            "city" => "Parharlin",
            "zip" => "457545754"
        ];

        // Options that will be sent within the request.
        $options = [
            "dataScope" => "basic",
            "cityFormat" => "minimal",
            "zipFormat" => true
        ];

        // Perform location data validation.
        $response = $this->api->location->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals("invalid", $result->proposal);
        $this->assertNotEmpty($result->errors);
    }

    /**
     * Test invalid location data with correction.
     */
    public function testInvalidWithCorrection()
    {
        // Query parameters for validating location data.
        $query = [
            "streetWithNumber" => "Thámova 137",
            "city" => "Praha",
            "zip" => "18600"
        ];

        // Options that will be sent within the request.
        $options = [
            "dataScope" => "basic",
            "cityFormat" => "minimal",
            "zipFormat" => true
        ];

        // Perform location data validation.
        $response = $this->api->location->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals("invalidWithCorrection", $result->proposal);
        $this->assertNotEmpty($response->getResultCorrected());
    }

    /**
     * Test invalid location data with suggestion.
     */
    public function testInvalidWithSuggestion()
    {
        // Query parameters for validating location data.
        $query = [
            "streetWithNumber" => "Olšanská 2898/4",
            "city" => "Praha",
            "zip" => "130 00"
        ];

        // Options that will be sent within the request.
        $options = [
            "dataScope" => "basic",
            "cityFormat" => "minimal",
            "zipFormat" => true
        ];

        // Perform location data validation.
        $response = $this->api->location->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals("invalidWithSuggestion", $result->proposal);
        $this->assertNotEmpty($response->getSuggestions());
    }

    /**
     * Test location data validation with custom ID.
     */
    public function testWithCustomId()
    {
        // Custom ID to identify the request.
        $customRequestID = 'MyCustomID';

        // Query parameters for validating location data.
        $query = [
            "streetWithNumber" => "Thámova 123456789",
            "city" => "Parharlin",
            "zip" => "457545754"
        ];

        // Options that will be sent within the request.
        $options = [
            "dataScope" => "basic",
            "cityFormat" => "minimal",
            "zipFormat" => true
        ];

        // Perform location data validation.
        $response = $this->api->location
            ->setCustomId($customRequestID)
            ->setOptions($options)
            ->validate($query);

        $request = $response->getRequest();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertNotEmpty($request->customId);
    }

    /**
     * Test location data validation with client information.
     */
    public function testWithClient()
    {
        // Query parameters for validating location data.
        $query = [
            "streetWithNumber" => "Thámova 137/16",
            "city" => "Praha",
            "zip" => "186 00"
        ];

        // Options that will be sent within the request.
        $options = [
            "dataScope" => "basic",
            "cityFormat" => "minimal",
            "zipFormat" => true
        ];

        // Perform location data validation with client information.
        $response = $this->api->location
            ->setOptions($options)
            ->setClientCountry("CZ")
            ->setClientIP("127.0.0.1")
            ->setClientLocation(50.073658, 14.418540)
            ->validate($query);

        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertTrue($result->isValid);
    }
}