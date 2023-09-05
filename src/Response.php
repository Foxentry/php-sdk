<?php

namespace Foxentry;

/**
 * Response class for handling API responses.
 *
 * @package Foxentry
 */
class Response
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * Response constructor.
     *
     * @param mixed $response The response data
     */
    public function __construct($response)
    {
        if (!is_object($response)) {
            $response = json_decode($response);
        }

        $this->data = $response;
    }

    /**
     * Get the status from the API response.
     *
     * @return mixed|null The status of the response
     */
    public function getStatus()
    {
        return $this->data->status ?? null;
    }

    /**
     * Get the request details from the API response.
     *
     * @return mixed|null The request details or null if not present in the response
     */
    public function getRequest()
    {
        return $this->data->request ?? null;
    }

    /**
     * Get the response data from the API response.
     *
     * @return mixed|null The response data or null if not present in the response
     */
    public function getResponse()
    {
        return $this->data->response ?? null;
    }

    /**
     * Get the result from the API response.
     *
     * @return mixed|null The result or null if not present in the response
     */
    public function getResult()
    {
        $result = $this->getResponse()->result ?? null;
        if(empty($result))
            $result = $this->getResponse()->results ?? null;

        return $result;
    }

    /**
     * Get the corrected result from the API response.
     *
     * @return mixed|null The corrected result or null if not present in the response
     */
    public function getResultCorrected()
    {
        return $this->getResponse()->resultCorrected ?? null;
    }

    /**
     * Get the suggestions from the API response.
     *
     * @return mixed|null The suggestions or null if not present in the response
     */
    public function getSuggestions()
    {
        return $this->getResponse()->suggestions ?? null;
    }

    /**
     * Get the errors from the API response.
     *
     * @return mixed|null The errors or null if not present in the response
     */
    public function getErrors()
    {
        return $this->data->errors ?? null;
    }
}