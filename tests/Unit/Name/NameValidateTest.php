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
        $options = [
            'dataScope' => 'basic',
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
        $options = [
            'dataScope' => 'basic',
            'validationDepth' => 'strict',
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
            'name' => 'Palve',
        ];

        // Options that will be sent within the request.
        $options = [
            'dataScope' => 'basic',
            'validationDepth' => 'strict',
        ];

        // Perform name validation.
        $response = self::$api->name()->setOptions($options)->validate($query);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals('invalidWithCorrection', $result->proposal);
        $this->assertNotEmpty($response->getResultCorrected());
    }

    /**
     * Test valid full name validation.
     */
    public function tesValidNameSurnameFullDataScope(): void
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
        $this->assertFalse($result->isValid);
        $this->assertEquals('valid', $result->proposal);
        $this->assertNotEmpty($result->details);
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
