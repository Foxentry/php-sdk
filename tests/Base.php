<?php
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
        $this->assertNotEmpty(Config::API_KEY, 'You didn\'t set your API key in the \test\Config.php file');
        $this->api = new ApiClient(Config::API_KEY);
    }
}