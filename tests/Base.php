<?php
namespace Tests;

use Foxentry\ApiClient;
use PHPUnit\Framework\TestCase;

class Base extends TestCase
{
    /**
     * @var ?ApiClient $api Foxentry API client.
     */
    protected ?ApiClient $api;

    public function setUp(): void
    {
        $this->assertNotEmpty($_ENV['API_KEY'], 'You didn\'t set your API key in .env file');
        $this->api = new ApiClient($_ENV['API_KEY']);
    }

    public function tearDown(): void
    {
        $this->api = null;
    }
}
