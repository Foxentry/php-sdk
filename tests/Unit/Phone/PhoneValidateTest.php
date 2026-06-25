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
            'numberFull' => '+420607123456',
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
            'numberFull' => '+42060712345',
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
     * Test a valid phone number supplied via the separate prefix + number fields.
     */
    public function testValidWithPrefixAndNumber(): void
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
        self::assertEquals('valid', $result->proposal);
    }

    /**
     * Test an invalid phone number supplied via the separate prefix + number fields.
     */
    public function testInvalidWithPrefixAndNumber(): void
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
        self::assertEquals('invalid', $result->proposal);
        self::assertNotEmpty($result->errors);
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
            'numberFull' => '+420607123456',
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
            'numberFull' => '+420607123456',
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
     * Test the API 2.1 `numberFormat` option and the renamed `result.data.format` object.
     */
    public function testNumberFormat(): void
    {
        // Phone number that will be sent to the API for validation.
        $query = [
            'numberFull' => '+420607123456',
        ];

        // API 2.1 replaces the boolean `formatNumber` with the `numberFormat` enum.
        $options = [
            'validationType' => 'extended',
            'numberFormat' => 'e164',
        ];

        // Perform phone number validation.
        $response = self::$api->phone()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        self::assertEquals(200, $response->getStatus());
        self::assertTrue($result->isValid);

        // API 2.1 renamed the `format` keys to standard telephony notations.
        $format = $result->data->format;
        self::assertObjectHasProperty('raw', $format);
        self::assertObjectHasProperty('national', $format);
        self::assertObjectHasProperty('e164', $format);
        self::assertObjectHasProperty('e123', $format);
        self::assertEquals('+420607123456', $format->e164);
    }

    /**
     * The client targets API version 2.1 by default; the response should echo it.
     */
    public function testApiVersion(): void
    {
        // Phone number that will be sent to the API for validation.
        $query = [
            'numberFull' => '+420607123456',
        ];

        // Perform phone number validation.
        $response = self::$api->phone()->validate($query);

        // Assertions.
        self::assertEquals(200, $response->getStatus());
        self::assertEquals(2.1, $response->getApiVersion());
    }

    /**
     * Settings should not persist between calls.
     */
    public function testInstanceSettings(): void
    {
        // Name that will be sent to the API for validation.
        $query = [
            'numberFull' => '+420607123456',
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
