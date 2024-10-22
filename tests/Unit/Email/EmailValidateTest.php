<?php

declare(strict_types=1);

namespace Tests\Unit\Email;

use Foxentry\Response;
use Tests\Base;

/**
 * PHPUnit test case for Email validation
 */
class EmailValidateTest extends Base
{
    /**
     * Test valid email validation.
     */
    public function testValid(): void
    {
        // Email that will be sent to the API for validation.
        $email = "info@foxentry.com";

        // Options that will be sent within the request.
        $options = [
            "validationType" => "extended",
        ];

        // Perform email validation.
        $response = self::$api->email()->setOptions($options)->validate($email);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertTrue($result->isValid);
        $this->assertEquals("valid", $result->proposal);
        $this->assertNotEmpty($result->data);
    }

    /**
     * Test invalid email.
     */
    public function testInvalid(): void
    {
        // Email that will be sent to the API for validation.
        $email = "invalidUser@foxentry.com";

        // Options that will be sent within the request.
        $options = [
            "validationType" => "extended",
        ];

        // Perform email validation.
        $response = self::$api->email()->setOptions($options)->validate($email);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals("invalid", $result->proposal);
        $this->assertNotEmpty($result->errors);
    }

    /**
     * Test invalid email with suggestion.
     */
    public function testInvalidWithSuggestion(): void
    {
        // Email that will be sent to the API for validation.
        $email = "info@gmali.com";

        // Options that will be sent within the request.
        $options = [
            "validationType" => "extended",
        ];

        // Perform email validation.
        $response = self::$api->email()->setOptions($options)->validate($email);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals("invalidWithSuggestion", $result->proposal);
        $this->assertNotEmpty($response->getSuggestions());
    }

    /**
     * Test invalid email with correction.
     */
    public function testInvalidWithCorrection(): void
    {
        // Email that will be sent to the API for validation.
        $email = "info@foxentry,com"; // Notice the "," instead of "." before the com

        // Options that will be sent within the request.
        $options = [
            "validationType" => "extended",
        ];

        // Perform email validation.
        $response = self::$api->email()->setOptions($options)->validate($email);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals("invalidWithCorrection", $result->proposal);
        $this->assertNotEmpty($response->getResultCorrected());
    }

    /**
     * Test invalid email with partial correction.
     */
    public function testInvalidWithPartialCorrection(): void
    {
        // Email that will be sent to the API for validation.
        $email = "infogmail.com";

        // Options that will be sent within the request.
        $options = [
            "validationType" => "extended",
        ];

        // Perform email validation.
        $response = self::$api->email()->setOptions($options)->validate($email);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals("invalidWithPartialCorrection", $result->proposal);
        $this->assertNotEmpty($response->getResultCorrected());
    }

    /**
     * Test disallowed disposable email.
     */
    public function testDisallowedDisposable(): void
    {
        // Email that will be sent to the API for validation.
        $email = "rasini3451@naymedia.com";

        // Options that will be sent within the request.
        $options = [
            "acceptDisposableEmails" => false,
        ];

        // Perform email validation.
        $response = self::$api->email()->setOptions($options)->validate($email);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals("invalid", $result->proposal);
        $this->assertTrue($result->flags->isDisposableEmailAddress);
        $this->assertNotEmpty($result->errors);
    }

    /**
     * Test disallowed freemail.
     */
    public function testDisallowedFreemails(): void
    {
        // Email that will be sent to the API for validation.
        $email = "info@gmail.com";

        // Options that will be sent within the request.
        $options = [
            "acceptFreemails" => false,
        ];

        // Perform email validation.
        $response = self::$api->email()->setOptions($options)->validate($email);
        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertFalse($result->isValid);
        $this->assertEquals("invalid", $result->proposal);
        $this->assertTrue($result->flags->isFreemail);
        $this->assertNotEmpty($result->errors);
    }

    /**
     * Test email validation with custom ID.
     */
    public function testWithCustomId(): void
    {
        // Custom ID to identify the request.
        $customRequestID = 'orderEmailValidation';

        // Valid email address for testing.
        $email = 'info@foxentry.com';

        // Perform email validation.
        $response = self::$api->email()
            ->setCustomId($customRequestID)
            ->validate($email);

        $request = $response->getRequest();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertNotEmpty($request->customId);
    }

    /**
     * Test email validation with client information.
     */
    public function testWithClient(): void
    {
        // Email that will be sent to the API for validation.
        $email = 'info@foxentry.com';

        // Perform email validation with client information.
        $response = self::$api->email()
            ->setClientCountry("CZ")
            ->setClientIP("127.0.0.1")
            ->setClientLocation(50.073658, 14.418540)
            ->validate($email);

        $result = $response->getResult();

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
        $this->assertTrue($result->isValid);
    }

    /**
     * Test email validation when the input parameter is specified as the entire query.
     */
    public function testQueryInput(): void
    {
        // Query that will be sent to the API for validation.
        $query = [
            "email" => "info@foxentry.com",
        ];

        // Options that will be sent within the request.
        $options = [
            "validationType" => "extended",
        ];

        // Perform email validation.
        $response = self::$api->email()->setOptions($options)->validate($query);

        // Assertions.
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatus());
    }

    /**
     * Test of receiving response headers
     */
    public function testResponseHeaders(): void
    {
        // Email that will be sent to the API for validation.
        $email = "info@foxentry.com";

        // Options that will be sent within the request.
        $options = [
            "validationType" => "extended",
        ];

        // Perform email validation and get headers of the response.
        $response = self::$api->email()->setOptions($options)->validate($email);
        $headers = $response->getHeaders();
        $rateLimit = $response->getRateLimit();
        $rateLimitPeriod = $response->getRateLimitPeriod();
        $rateLimitRemaining = $response->getRateLimitRemaining();
        $apiVersion = $response->getApiVersion();

        // Assertions.
        $this->assertIsArray($headers);
        $this->assertNotEmpty($headers);
        $this->assertIsNumeric($rateLimit);
        $this->assertIsNumeric($rateLimitPeriod);
        $this->assertIsNumeric($rateLimitRemaining);
        $this->assertIsNumeric($apiVersion);
    }

    /**
     * Settings should not persist between calls.
     */
    public function testInstanceSettings(): void
    {
        // Name that will be sent to the API for validation.
         $email = "info@foxentry.com";

        // Perform name validation with client information.
        $response = self::$api->email()
            ->includeRequestDetails()
            ->validate($email);

        $result = $response->getRequest();


        $this->assertObjectHasProperty('query', $result);

        $response = self::$api->email()
            ->validate($email);

        $result = $response->getRequest();

        $this->assertObjectNotHasProperty('query', $result);
    }
}
