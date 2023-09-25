<?php

namespace Foxentry\Resources;

use Foxentry\Response;

/**
 * Email resource class for validating and searching email addresses.
 *
 * @package Foxentry\Resources
 */
final class Email extends BaseResource
{
    /**
     * Validate an email address.
     *
     * @param string|array $query Email address to validate
     *
     * @return Response The response from the validation request
     */
    public function validate($query): Response
    {
        $query = is_array($query) ? $query : ["email" => $query];
        return $this->sendRequest($query);
    }

    /**
     * Search for information related to an email address.
     *
     * @param string|array $query Email address to search for
     *
     * @return Response The response from the search request
     */
    public function search($query): Response
    {
        $query = is_array($query) ? $query : ["value" => $query];
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
