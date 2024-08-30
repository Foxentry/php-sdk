<?php

namespace Foxentry;

use Foxentry\Resource\Company;
use Foxentry\Resource\Email;
use Foxentry\Resource\Location;
use Foxentry\Resource\Name;
use Foxentry\Resource\Phone;

/**
 * API client class for interacting with Foxentry API.
 *
 * @package Foxentry
 */
class ApiClient {

    protected string $apiKey;
    protected string $apiVersion = "2.0";

    /**
     * ApiClient constructor.
     *
     * @param string|null $apiKey The API key for authentication
     */
    public function __construct( ?string $apiKey = null ) {
        if ($apiKey !== null) {
            $this->setAuth($apiKey);
        }
    }


    /**
     * Set API key for authentication.
     *
     * @param string $apiKey The API key to set
     */
    public function setAuth( string $apiKey ): void {
        $this->apiKey = $apiKey;
    }

    /**
     * Set the API version for requests.
     *
     * @param string $version The API version to set
     */
    public function setApiVersion( string $version ): void {
        $this->apiVersion = $version;
    }


    function company() {
        $request = new Request($this->apiVersion, $this->apiKey);
        return new Company( $request );
    }

    function email() {
        $request = new Request($this->apiVersion, $this->apiKey);
        return new Email( $request );
    }

    function location() {
        $request = new Request($this->apiVersion, $this->apiKey);
        return new Location( $request );
    }

    function name() {
        $request = new Request($this->apiVersion, $this->apiKey);
        return new Name( $request );
    }

    function phone() {
        $request = new Request($this->apiVersion, $this->apiKey);
        return new Phone( $request );
    }

}
