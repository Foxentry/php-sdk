<?php

namespace Tests\Unit\Location;

use Foxentry\Response;
use Tests\Base;

/**
 * PHPUnit test case for retrieving company data
 */
class CompanyGetTest extends Base
{
    /**
     * Test retrieval of basic data scope by country and registration number.
     */
    public function testBasicDataScope()
    {
        // Query parameters for retrieving company data by country and registration number.
        $query = [
            "country" => "CZ",
            "registrationNumber" => "04997476"
        ];

        // Options that will be sent within the request.
        $options = [
            "dataScope" => "basic"
        ];

        // Perform company data retrieval.
        $response = $this->api->company()->setOptions($options)->get($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertNotEmpty($result[0]->data);
    }

    /**
     * Test retrieval of extended data scope by country and registration number.
     */
    public function testExtendedDataScope()
    {
        // Query parameters for retrieving company data by country and registration number.
        $query = [
            "country" => "CZ",
            "registrationNumber" => "04997476"
        ];

        // Options that will be sent within the request.
        $options = [
            "dataScope" => "extended"
        ];

        // Perform company data retrieval.
        $response = $this->api->company()->setOptions($options)->get($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertNotEmpty($result[0]->data->vat);
    }

    /**
     * Test retrieval of full data scope by country and registration number.
     */
    public function testFullDataScope()
    {
        // Query parameters for retrieving company data by country and registration number.
        $query = [
            "country" => "CZ",
            "registrationNumber" => "04997476"
        ];

        // Options that will be sent within the request.
        $options = [
            "dataScope" => "full"
        ];

        // Perform company data retrieval.
        $response = $this->api->company()->setOptions($options)->get($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertNotEmpty($result[0]->data->registrations);
    }

    /**
     * Test company data retrieval with custom ID.
     */
    public function testWithCustomId()
    {
        // Custom ID to identify the request.
        $customRequestID = 'MyCustomID';

        // Query parameters for company data retrieval.
        $query = [
            "country" => "CZ",
            "registrationNumber" => "04997476"
        ];

        // Options that will be sent within the request.
        $options = [
            "dataScope" => "basic"
        ];

        // Perform company data retrieval.
        $response = $this->api->company()
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
     * Test company data retrieval with client information.
     */
    public function testWithClient()
    {
        // Query parameters for company data retrieval.
        $query = [
            "country" => "CZ",
            "registrationNumber" => "04997476"
        ];

        // Options that will be sent within the request.
        $options = [
            "dataScope" => "basic"
        ];

        // Perform company data retrieval with client information.
        $response = $this->api->company()
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
}
