<?php

namespace Foxentry\Resources;

use Foxentry\Response;

/**
 * Company resource class for validating, searching, and retrieving company information.
 *
 * @package Foxentry\Resources
 */
final class Company extends BaseResource
{
    /**
     * Validate a company.
     *
     * @param array $query Query parameters for the validation request
     *
     * @return Response The response from the validation request
     */
    public function validate(array $query): Response
    {
        return $this->sendRequest($query);
    }

    /**
     * Search for a company.
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
     * Get company details.
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