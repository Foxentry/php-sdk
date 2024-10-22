<?php

declare(strict_types=1);

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
    public function testValid(): void
    {
        // Phone number with prefix that will be sent to the API for validation.
        $query = [
            'numberWithPrefix' => '+420607123456',
        ];

        // Options that will be sent within the request.
        $options = [
            'validationType' => 'extended',
        ];

        // Perform phone number validation.
        $response = self::$api->phone()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatus());
        self::assertTrue($result->isValid);
        self::assertEquals('valid', $result->proposal);
        self::assertNotEmpty($result->data);
    }

    /**
     * Test invalid phone number.
     */
    public function testInvalid(): void
    {
        // Phone number with prefix that will be sent to the API for validation.
        $query = [
            'numberWithPrefix' => '+42060712345',
        ];

        // Options that will be sent within the request.
        $options = [
            'validationType' => 'extended',
        ];

        // Perform phone number validation.
        $response = self::$api->phone()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatus());
        self::assertFalse($result->isValid);
        self::assertEquals('invalid', $result->proposal);
        self::assertNotEmpty($result->errors);
    }

    /**
     * Test valid phone number with suggestion.
     */
    public function testValidWithSuggestion(): void
    {
        // Phone number and prefix that will be sent to the API for validation.
        $query = [
            'prefix' => '+48',
            'number' => '728984101',
        ];

        // Options that will be sent within the request.
        $options = [
            'validationType' => 'extended',
        ];

        // Perform phone number validation.
        $response = self::$api->phone()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatus());
        self::assertTrue($result->isValid);
        self::assertEquals('validWithSuggestion', $result->proposal);
        self::assertNotEmpty($response->getSuggestions());
    }

    /**
     * Test invalid phone number with correction.
     */
    public function testInvalidWithCorrection(): void
    {
        // Phone number and prefix that will be sent to the API for validation.
        $query = [
            'prefix' => '+421',
            'number' => '607123456',
        ];

        // Options that will be sent within the request.
        $options = [
            'validationType' => 'extended',
        ];

        // Perform phone number validation.
        $response = self::$api->phone()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatus());
        self::assertFalse($result->isValid);
        self::assertEquals('invalidWithCorrection', $result->proposal);
        self::assertNotEmpty($response->getResultCorrected());
    }

    /**
     * Test phone number validation with custom ID.
     */
    public function testWithCustomId(): void
    {
        // Custom ID to identify the request.
        $customRequestID = 'orderPhoneValidation';

        // Phone number with prefix that will be sent to the API for validation.
        $query = [
            'numberWithPrefix' => '+420607123456',
        ];

        // Perform phone number validation.
        $response = self::$api->phone()
            ->setCustomId($customRequestID)
            ->validate($query);

        $request = $response->getRequest();

        // Assertions.
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatus());
        self::assertNotEmpty($request->customId);
    }

    /**
     * Test phone number validation with client information.
     */
    public function testWithClient(): void
    {
        // Phone number with prefix that will be sent to the API for validation.
        $query = [
            'numberWithPrefix' => '+420607123456',
        ];

        // Perform phone number validation with client information.
        $response = self::$api->phone()
            ->setClientCountry('CZ')
            ->setClientIP('127.0.0.1')
            ->setClientLocation(50.073658, 14.418540)
            ->validate($query);

        $result = $response->getResult();

        // Assertions.
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatus());
        self::assertTrue($result->isValid);
    }

    /**
     * Settings should not persist between calls.
     */
    public function testInstanceSettings(): void
    {
        // Name that will be sent to the API for validation.
        $query = [
            'numberWithPrefix' => '+420607123456',
        ];

        // Perform name validation with client information.
        $response = self::$api->phone()
            ->includeRequestDetails()
            ->validate($query);

        $result = $response->getRequest();


        self::assertObjectHasProperty('query', $result);

        $response = self::$api->phone()
            ->validate($query);

        $result = $response->getRequest();

        self::assertObjectNotHasProperty('query', $result);
    }
}
