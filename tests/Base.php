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
    protected ApiClient $api;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->assertNotEmpty($_ENV['API_KEY'], 'You didn\'t set your API key in .env file');
        $this->api = new ApiClient($_ENV['API_KEY']);
    }
}
