<?php

namespace Tests\Unit\Phone;

use Foxentry\Response;
use Tests\Base;

/**
 * PHPUnit test case for Phone number validation
 */
class PhoneValidateTest extends Base
{
    /**
     * Test valid phone number validation.
     */
    public function testValid()
    {
        // Phone number with prefix that will be sent to the API for validation.
        $query = [
            "numberWithPrefix" => "+420607123456"
        ];

        // Options that will be sent within the request.
        $options = [
            "validationType" => "extended"
        ];

        // Perform phone number validation.
        $response = $this->api->phone()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertTrue($result->isValid);
        $this->assertEquals("valid", $result->proposal);
        $this->assertNotEmpty($result->data);
    }

    /**
     * Test invalid phone number.
     */
    public function testInvalid()
    {
        // Phone number with prefix that will be sent to the API for validation.
        $query = [
            "numberWithPrefix" => "+42060712345"
        ];

        // Options that will be sent within the request.
        $options = [
            "validationType" => "extended"
        ];

        // Perform phone number validation.
        $response = $this->api->phone()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals("invalid", $result->proposal);
        $this->assertNotEmpty($result->errors);
    }

    /**
     * Test valid phone number with suggestion.
     */
    public function testValidWithSuggestion()
    {
        // Phone number and prefix that will be sent to the API for validation.
        $query = [
            "prefix" => "+48",
            "number" => "728984101"
        ];

        // Options that will be sent within the request.
        $options = [
            "validationType" => "extended"
        ];

        // Perform phone number validation.
        $response = $this->api->phone()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertTrue($result->isValid);
        $this->assertEquals("validWithSuggestion", $result->proposal);
        $this->assertNotEmpty($response->getSuggestions());
    }

    /**
     * Test invalid phone number with correction.
     */
    public function testInvalidWithCorrection()
    {
        // Phone number and prefix that will be sent to the API for validation.
        $query = [
            "prefix" => "+421",
            "number" => "607123456"
        ];

        // Options that will be sent within the request.
        $options = [
            "validationType" => "extended"
        ];

        // Perform phone number validation.
        $response = $this->api->phone()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals("invalidWithCorrection", $result->proposal);
        $this->assertNotEmpty($response->getResultCorrected());
    }

    /**
     * Test phone number validation with custom ID.
     */
    public function testWithCustomId()
    {
        // Custom ID to identify the request.
        $customRequestID = 'orderPhoneValidation';

        // Phone number with prefix that will be sent to the API for validation.
        $query = [
            "numberWithPrefix" => "+420607123456"
        ];

        // Perform phone number validation.
        $response = $this->api->phone()
            ->setCustomId($customRequestID)
            ->validate($query);

        $request = $response->getRequest();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertNotEmpty($request->customId);
    }

    /**
     * Test phone number validation with client information.
     */
    public function testWithClient()
    {
        // Phone number with prefix that will be sent to the API for validation.
        $query = [
            "numberWithPrefix" => "+420607123456"
        ];

        // Perform phone number validation with client information.
        $response = $this->api->phone()
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

    /**
     * Settings should not persist between calls.
     */
    public function testInstanceSettings()
    {
        // Name that will be sent to the API for validation.
        $query = [
            "numberWithPrefix" => "+420607123456"
        ];

        // Perform name validation with client information.
        $response = $this->api->phone()
            ->includeRequestDetails()
            ->validate($query);

        $result = $response->getRequest();


        $this->assertObjectHasProperty('query', $result);

        $response = $this->api->phone()
            ->validate($query);

        $result = $response->getRequest();

        $this->assertObjectNotHasProperty('query', $result);
    }
}
