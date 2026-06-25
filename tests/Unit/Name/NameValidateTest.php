<?php

declare(strict_types=1);

namespace Tests\Unit\Name;

use Foxentry\Response;
use Tests\Base;

/**
 * PHPUnit test case for Name validation
 */
class NameValidateTest extends Base
{
    /**
     * Test valid name validation.
     */
    public function testValid(): void
    {
        // Name that will be sent to the API for validation.
        $query = [
            'name' => 'Pavel',
        ];

        // Options that will be sent within the request.
        // correctionMode "none" keeps the proposal at a plain "valid" (the API 2.1
        // default is "full", which would auto-correct casing into "validWithCorrection").
        $options = [
            'dataScope' => 'basic',
            'correctionMode' => 'none',
        ];

        // Perform name validation.
        $response = self::$api->name()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertTrue($result->isValid);
        $this->assertEquals('valid', $result->proposal);
        $this->assertNotEmpty($result->data);
    }

    /**
     * Test invalid name.
     */
    public function testInvalid(): void
    {
        // Name that will be sent to the API for validation.
        $query = [
            'name' => 'Paeeewas',
        ];

        // Options that will be sent within the request.
        // correctionMode "none" keeps the proposal at a plain "invalid" rather than
        // "invalidWithPartialCorrection" produced by the API 2.1 default of "full".
        $options = [
            'dataScope' => 'basic',
            'correctionMode' => 'none',
        ];

        // Perform name validation.
        $response = self::$api->name()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals('invalid', $result->proposal);
        $this->assertNotEmpty($result->errors);
    }

    /**
     * Test invalid name with correction.
     */
    public function testInvalidWithCorrection(): void
    {
        // Name that will be sent to the API for validation.
        $query = [
            'name' => 'PaVelll',
        ];

        // Options that will be sent within the request.
        $options = [
            'dataScope' => 'basic',
            'correctionMode' => 'full',
        ];

        // Perform name validation.
        $response = self::$api->name()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals('invalidWithPartialCorrection', $result->proposal);
        $this->assertNotEmpty($response->getResultCorrected());
    }

    /**
     * Test valid full name validation.
     */
    public function testValidNameSurnameFullDataScope(): void
    {
        // Full name that will be sent to the API for validation.
        $query = [
            'nameSurname' => 'Pavel Novák',
        ];

        // Options that will be sent within the request.
        $options = [
            'dataScope' => 'full',
        ];

        // Perform full name validation.
        $response = self::$api->name()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertTrue($result->isValid);
        $this->assertEquals('valid', $result->proposal);
        // In API 2.1 the "details" object moved from result root into result.data.
        $this->assertNotEmpty($result->data->details);
    }

    /**
     * Test the API 2.1 `correctionMode: suggestion` option, which offers the
     * corrected data as a suggestion instead of applying it.
     */
    public function testCorrectionModeSuggestion(): void
    {
        // Name that will be sent to the API for validation.
        $query = [
            'name' => 'PaVelll',
        ];

        // Options that will be sent within the request.
        $options = [
            'dataScope' => 'basic',
            'correctionMode' => 'suggestion',
        ];

        // Perform name validation.
        $response = self::$api->name()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals('invalidWithSuggestion', $result->proposal);
        $this->assertNotEmpty($response->getSuggestions());
    }

    /**
     * Test the API 2.1 additive fields: vocative (5th case) forms in
     * result.data and the new `dataTypes` report.
     */
    public function testVocativeFormsAndDataTypes(): void
    {
        // Full name that will be sent to the API for validation.
        $query = [
            'nameSurname' => 'Petr Novák',
        ];

        // Options that will be sent within the request.
        $options = [
            'dataScope' => 'full',
            'dataLanguage' => 'cs',
        ];

        // Perform full name validation.
        $response = self::$api->name()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertEquals(200, $response->getStatus());
        $this->assertTrue($result->isValid);

        // Vocative forms are new additive fields in result.data.
        $this->assertObjectHasProperty('vocativeName', $result->data);
        $this->assertObjectHasProperty('vocativeSurname', $result->data);
        $this->assertObjectHasProperty('vocativeNameSurname', $result->data);

        // The new dataTypes report lists valid/invalid queried components.
        $this->assertObjectHasProperty('dataTypes', $result);
        $this->assertContains('name', $result->dataTypes->valid);
        $this->assertContains('surname', $result->dataTypes->valid);
    }

    /**
     * Test name validation with custom ID.
     */
    public function testWithCustomId(): void
    {
        // Custom ID to identify the request.
        $customRequestID = 'MyCustomID';

        // Name that will be sent to the API for validation.
        $query = [
            'name' => 'Pavel',
        ];

        // Perform name validation.
        $response = self::$api->name()
            ->setCustomId($customRequestID)
            ->validate($query);

        $request = $response->getRequest();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertNotEmpty($request->customId);
    }

    /**
     * Test name validation with client information.
     */
    public function testWithClient(): void
    {
        // Name that will be sent to the API for validation.
        $query = [
            'name' => 'Pavel',
        ];

        // Options that will be sent within the request.
        $options = [
            'dataScope' => 'basic',
        ];

        // Perform name validation with client information.
        $response = self::$api->name()
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

    /**
     * Settings should not persist between calls.
     */
    public function testInstanceSettings(): void
    {
        // Name that will be sent to the API for validation.
        $query = [
            'name' => 'Pavel',
        ];

        // Options that will be sent within the request.
        $options = [
            'dataScope' => 'basic',
        ];

        // Perform name validation with client information.
        $response = self::$api->name()
            ->setOptions($options)
            ->includeRequestDetails()
            ->validate($query);

        $result = $response->getRequest();


        $this->assertObjectHasProperty('query', $result);

        $response = self::$api->name()
            ->setOptions($options)
            ->validate($query);

        $result = $response->getRequest();

        $this->assertObjectNotHasProperty('query', $result);
    }
}
