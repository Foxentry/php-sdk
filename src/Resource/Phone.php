<?php

namespace Foxentry\Resource;

use Foxentry\Response;

/**
 * Phone resource class for validating phone numbers.
 *
 * @package Foxentry\Resource
 */
final class Phone extends BaseResource
{
    /**
     * Validate a phone number.
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