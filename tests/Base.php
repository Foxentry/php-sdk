<?php

declare(strict_types=1);

namespace Tests;

use Foxentry\ApiClient;
use PHPUnit\Framework\TestCase;

class Base extends TestCase
{
    /**
     * @var ApiClient $api Foxentry API client.
     */
    protected static ApiClient $api;

    public static function setUpBeforeClass(): void
    {
        self::assertNotEmpty($_ENV['API_KEY'], 'You didn\'t set your API key in .env file');
        self::$api = new ApiClient($_ENV['API_KEY']);
    }
}
