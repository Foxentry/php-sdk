<?php

declare(strict_types=1);

namespace Tests\Unit\Location;

use Foxentry\Response;
use Tests\Base;

/**
 * PHPUnit test case for location search.
 */
class LocationSearchTest extends Base
{
    /**
     * Test valid street search.
     */
    public function testSearchStreet(): void
    {
        // Input parameters for street search.
        $query = [
            "type" => "street",
            "value" => "tha",
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10,
        ];

        // Perform street search.
        $response = $this->api->location()->setOptions($options)->search($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($result);
    }

    /**
     * Test valid city search.
     */
    public function testSearchCity(): void
    {
        // Input parameters for city search.
        $query = [
            "type" => "city",
            "value" => "pra",
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10,
        ];

        // Perform city search.
        $response = $this->api->location()->setOptions($options)->search($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($result);
    }

    /**
     * Test valid street with number search.
     */
    public function testSearchStreetWithNumber(): void
    {
        // Input parameters for street with number search.
        $query = [
            "type" => "streetWithNumber",
            "value" => "Jeseniova 56",
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10,
        ];

        // Perform street with number search.
        $response = $this->api->location()->setOptions($options)->search($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($result);
    }

    /**
     * Test valid ZIP code search.
     */
    public function testSearchZip(): void
    {
        // Input parameters for ZIP code search.
        $query = [
            "type" => "zip",
            "value" => "1",
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10,
        ];

        // Perform ZIP code search.
        $response = $this->api->location()->setOptions($options)->search($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($result);
    }

    /**
     * Test valid full address search.
     */
    public function testSearchFull(): void
    {
        // Input parameters for full location search.
        $query = [
            "type" => "full",
            "value" => "Jeseniova Praha",
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10,
        ];

        // Perform full location search.
        $response = $this->api->location()->setOptions($options)->search($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($result);
    }

    /**
     * Test location data validation with custom ID.
     */
    public function testWithCustomId(): void
    {
        // Custom ID to identify the request.
        $customRequestID = 'MyCustomID';

        // Input parameters for street search.
        $query = [
            "type" => "street",
            "value" => "tha",
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10,
        ];

        // Perform location data validation.
        $response = $this->api->location()
            ->setCustomId($customRequestID)
            ->setOptions($options)
            ->search($query);

        $request = $response->getRequest();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($request->customId);
    }

    /**
     * Test location data validation with client information.
     */
    public function testWithClient(): void
    {
        // Input parameters for street search.
        $query = [
            "type" => "street",
            "value" => "tha",
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10,
        ];

        // Perform location data validation with client information.
        $response = $this->api->location()
            ->setOptions($options)
            ->setClientCountry("CZ")
            ->setClientIP("127.0.0.1")
            ->setClientLocation(50.073658, 14.418540)
            ->search($query);

        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($result);
    }
}
