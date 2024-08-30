<?php

namespace Tests\Unit\Location;

use Foxentry\Response;
use Tests\Base;

/**
 * PHPUnit test case for Location data retrieval
 */
class LocationGetTest extends Base
{
    /**
     * Test retrieval of full data scope by internal ID.
     */
    public function testGetFullDataScopeByInternalID()
    {
        // Query parameters for retrieving location data by internal ID.
        $query = [
            "country" => "CZ",
            "id" => "d2ade877-1e95-4a83-baa6-5431ce5b3ca8"
        ];

        // Options that will be sent within the request.
        $options = [
            "idType" => "internal",
            "dataScope" => "full"
        ];

        // Perform location data retrieval.
        $response = $this->api->location()->setOptions($options)->get($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertNotEmpty($result[0]->data);
    }

    /**
     * Test retrieval of full data scope by external ID.
     */
    public function getFullDataScopeByExternalID()
    {
        // Query parameters for retrieving location data by external ID.
        $query = [
            "country" => "CZ",
            "id" => "22349995"
        ];

        // Options that will be sent within the request.
        $options = [
            "idType" => "external",
            "dataScope" => "full"
        ];

        // Perform location data retrieval.
        $response = $this->api->location()->setOptions($options)->get($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertNotEmpty($result[0]->data);
    }

    /**
     * Test location data retrieval with custom ID.
     */
    public function testWithCustomId()
    {
        // Custom ID to identify the request.
        $customRequestID = 'MyCustomID';

        // Query parameters for location data retrieval.
        $query = [
            "country" => "CZ",
            "id" => "22349995"
        ];

        // Options that will be sent within the request.
        $options = [
            "idType" => "external",
            "dataScope" => "full"
        ];

        // Perform location data retrieval.
        $response = $this->api->location()
            ->setCustomId($customRequestID)
            ->setOptions($options)
            ->get($query);

        $request = $response->getRequest();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertNotEmpty($request->customId);
    }

    /**
     * Test location data retrieval with client information.
     */
    public function testWithClient()
    {
        // Query parameters for location data retrieval.
        $query = [
            "country" => "CZ",
            "id" => "22349995"
        ];

        // Options that will be sent within the request.
        $options = [
            "idType" => "external",
            "dataScope" => "full"
        ];

        // Perform location data retrieval with client information.
        $response = $this->api->location()
            ->setOptions($options)
            ->setClientCountry("CZ")
            ->setClientIP("127.0.0.1")
            ->setClientLocation(50.073658, 14.418540)
            ->get($query);

        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertNotEmpty($result[0]->data);
    }

    /**
     * Settings should not persist between calls.
     */
    public function testInstanceSettings()
    {
        // Name that will be sent to the API for validation.
        $query = [
            "country" => "CZ",
            "id" => "22349995"
        ];

        // Options that will be sent within the request.
        $options = [
            "idType" => "external",
            "dataScope" => "basic"
        ];

        // Perform name validation with client information.
        $response = $this->api->location()
            ->setOptions($options)
            ->includeRequestDetails()
            ->get($query);

        $result = $response->getRequest();


        $this->assertObjectHasProperty('query', $result);

        $response = $this->api->location()
            ->setOptions($options)
            ->get($query);

        $result = $response->getRequest();

        $this->assertObjectNotHasProperty('query', $result);
    }
}
