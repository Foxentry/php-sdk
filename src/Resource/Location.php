<?php

namespace Foxentry\Resource;

use Foxentry\Response;

/**
 * Location resource class for validating, searching, and retrieving information about addresses
 *
 * @package Foxentry\Resource
 */
final class Location extends BaseResource
{
    /**
     * Validate an address.
     *
     * @param array $query Query parameters for the validation request
     * @return Response The response from the validation request
     */
    public function validate(array $query): Response
    {
        return $this->sendRequest($query);
    }

    /**
     * Search for a location.
     *
     * @param array $query Query parameters for the search request
     *
     * @return Response The response from the API
     */
    public function search(array $query): Response
    {
        return $this->sendRequest($query);
    }

    /**
     * Get location details.
     *
     * @param array $query Query parameters for the get request
     *
     * @return Response The response from the API
     */
    public function get(array $query): Response
    {
        return $this->sendRequest($query);
    }

    /**
     * Localize a location.
     *
     * @param array $query Query parameters for the localize request
     *
     * @return Response The response from the API
     */
    public function localize(array $query): Response
    {
        return $this->sendRequest($query);
    }

    /**
     * Send a request to the API with the given query parameters.
     *
     * @param array $query Query parameters for the request
     *
     * @return Response The response from the API
     */
    private function sendRequest(array $query): Response
    {
        return parent::send($query);
    }
}