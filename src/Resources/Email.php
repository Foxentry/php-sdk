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
     * @param string $email Email address to validate
     *
     * @return Response The response from the validation request
     */
    public function validate($email): Response
    {
        $query = ["email" => $email];
        return $this->sendRequest($query);
    }

    /**
     * Search for information related to an email address.
     *
     * @param string $email Email address to search for
     *
     * @return Response The response from the search request
     */
    public function search(string $email): Response
    {
        $query = ["value" => $email];
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
