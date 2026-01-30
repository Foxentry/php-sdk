<?php

declare(strict_types=1);

namespace Tests\Unit\Company;

use Foxentry\Response;
use Tests\Base;

/**
 * PHPUnit test case for validating company data
 */
class CompanyValidateTest extends Base
{
    /**
     * Test valid company data.
     */
    public function testValid(): void
    {
        // Query parameters for validating company data.
        $query = [
            'name' => 'AVANTRO s.r.o.',
            'registrationNumber' => '04997476',
        ];

        // Options that will be sent within the request.
        $options = [
            'dataScope' => 'basic',
        ];

        // Perform company data validation.
        $response = self::$api->company()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertTrue($result->isValid);
        $this->assertEquals('valid', $result->proposal);
        $this->assertNotEmpty($result->data);
    }

    /**
     * Test invalid company data.
     */
    public function testInvalid(): void
    {
        // Query parameters for validating company data.
        $query = [
            'name' => 'AVANTRO',
            'registrationNumber' => '25547',
        ];

        // Options that will be sent within the request.
        $options = [
            'dataScope' => 'basic',
        ];

        // Perform company data validation.
        $response = self::$api->company()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals('invalid', $result->proposal);
        $this->assertNotEmpty($result->errors);
    }

    /**
     * Test invalid company data with correction.
     */
    public function testInvalidWithCorrection(): void
    {
        // Query parameters for validating company data.
        $query = [
            'name' => 'AVANTRO',
            'registrationNumber' => '04997476',
        ];

        // Options that will be sent within the request.
        $options = [
            'dataScope' => 'basic',
        ];

        // Perform company data validation.
        $response = self::$api->company()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals('invalidWithCorrection', $result->proposal);
        $this->assertNotEmpty($response->getResultCorrected());
    }

    /**
     * Test invalid company data with suggestion.
     */
    public function testInvalidWithSuggestion(): void
    {
        // Query parameters for validating company data.
        $query = [
            'registrationNumber' => '0499747',
        ];

        // Options that will be sent within the request.
        $options = [
            'dataScope' => 'basic',
        ];

        // Perform company data validation.
        $response = self::$api->company()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals('invalidWithSuggestion', $result->proposal);
        $this->assertNotEmpty($response->getSuggestions());
    }

    /**
     * Test company data validation with custom ID.
     */
    public function testWithCustomId(): void
    {
        // Custom ID to identify the request.
        $customRequestID = 'MyCustomID';

        // Query parameters for validating company data.
        $query = [
            'name' => 'AVANTRO s.r.o.',
            'registrationNumber' => '04997476',
        ];

        // Options that will be sent within the request.
        $options = [
            'dataScope' => 'basic',
        ];

        // Perform company data validation.
        $response = self::$api->company()
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
     * Test company data validation with client information.
     */
    public function testWithClient(): void
    {
        // Query parameters for validating company data.
        $query = [
            'name' => 'AVANTRO s.r.o.',
            'registrationNumber' => '04997476',
        ];

        // Options that will be sent within the request.
        $options = [
            'dataScope' => 'basic',
        ];

        // Perform company data validation with client information.
        $response = self::$api->company()
            ->setOptions($options)
            ->setClientCountry('CZ')
            ->setClientIP('127.0.0.1')
            ->setClientLocation(50.073658, 14.418540)
            ->validate($query);

        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertTrue($result->isValid);
    }
}
