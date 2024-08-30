<?php

namespace Tests\Unit\Company;

use Foxentry\Response;
use Tests\Base;

/**
 * PHPUnit test case for company search
 */
class CompanySearchTest extends Base
{
    /**
     * Test valid company name search.
     */
    public function testSearchName()
    {
        // Input parameters for company name search.
        $query = [
            "type" => "name",
            "value" => "Web"
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10
        ];

        // Perform company name search.
        $response = $this->api->company()->setOptions($options)->search($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($result);
    }

    /**
     * Test valid registration number search.
     */
    public function testSearchRegistrationNumber()
    {
        // Input parameters for registration number search.
        $query = [
            "type" => "registrationNumber",
            "value" => "10"
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10
        ];

        // Perform registration number search.
        $response = $this->api->company()->setOptions($options)->search($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($result);
    }

    /**
     * Test valid tax number search.
     */
    public function testSearchTaxNumber()
    {
        // Input parameters for tax number search.
        $query = [
            "type" => "taxNumber",
            "value" => "10"
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10
        ];

        // Perform tax number search.
        $response = $this->api->company()->setOptions($options)->search($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($result);
    }

    /**
     * Test valid VAT number search.
     */
    public function testSearchVatNumber()
    {
        // Input parameters for VAT number search.
        $query = [
            "type" => "vatNumber",
            "value" => "CZ04997476"
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10
        ];

        // Perform VAT number search.
        $response = $this->api->company()->setOptions($options)->search($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertEmpty($response->getErrors());
        $this->assertGreaterThan(0, $response->getResponse()->resultsCount);
        $this->assertNotEmpty($result);
    }

    /**
     * Test company data search with custom ID.
     */
    public function testWithCustomId()
    {
        // Custom ID to identify the request.
        $customRequestID = 'MyCustomID';

        // Input parameters for company name search.
        $query = [
            "type" => "name",
            "value" => "Web"
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10
        ];

        // Perform company data search.
        $response = $this->api->company()
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
     * Test company data search with client information.
     */
    public function testWithClient()
    {
        // Input parameters for company name search.
        $query = [
            "type" => "name",
            "value" => "Web"
        ];

        // Options that will be sent within the request.
        $options = [
            "resultsLimit" => 10
        ];

        // Perform company data search with client information.
        $response = $this->api->company()
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
