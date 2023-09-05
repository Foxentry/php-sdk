<?php

namespace Foxentry\Resources;

use Foxentry\Response;

/**
 * Name resource class for validating names.
 *
 * @package Foxentry\Resources
 */
final class Name extends BaseResource
{
    /**
     * Validate a name.
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
