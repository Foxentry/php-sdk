<?php

declare(strict_types=1);

namespace Tests\Unit\Location;

use Foxentry\Response;
use Tests\Base;

/**
 * PHPUnit test case for Location data localization
 */
class LocationLocalizeTest extends Base
{
    /**
     * Test localization of location data based on coordinates.
     */
    public function testLocalizationResults(): void
    {
        // Query parameters for localizing location data.
        $query = [
            "lat" => 50.0919999,
            "lon" => 14.4527403,
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10,
            "radius" => 15,
            "acceptNearest" => false,
        ];

        // Perform location data localization.
        $response = self::$api->location()->setOptions($options)->localize($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($result);
    }

    /**
     * Test location data localization with custom ID.
     */
    public function testWithCustomId(): void
    {
        // Custom ID to identify the request.
        $customRequestID = 'MyCustomID';

        // Query parameters for localizing location data.
        $query = [
            "lat" => 50.0919999,
            "lon" => 14.4527403,
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10,
            "radius" => 15,
            "acceptNearest" => false,
        ];

        // Perform location data localization.
        $response = self::$api->location()
            ->setCustomId($customRequestID)
            ->setOptions($options)
            ->localize($query);

        $request = $response->getRequest();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($request->customId);
    }

    /**
     * Test location data localization with client information.
     */
    public function testWithClient(): void
    {
        // Query parameters for localizing location data.
        $query = [
            "lat" => 50.0919999,
            "lon" => 14.4527403,
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10,
            "radius" => 15,
            "acceptNearest" => false,
        ];

        // Perform location data localization with client information.
        $response = self::$api->location()
            ->setOptions($options)
            ->setClientCountry("CZ")
            ->setClientIP("127.0.0.1")
            ->setClientLocation(50.073658, 14.418540)
            ->localize($query);

        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($result);
    }
}
