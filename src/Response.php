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
    public function status()
    {
        return $this->data->status ?? null;
    }

    /**
     * Get the request details from the API response.
     *
     * @return mixed|null The request details or null if not present in the response
     */
    public function request()
    {
        return $this->data->request ?? null;
    }

    /**
     * Get the response data from the API response.
     *
     * @return mixed|null The response data or null if not present in the response
     */
    public function response()
    {
        return $this->data->response ?? null;
    }

    /**
     * Get the result from the API response.
     *
     * @return mixed|null The result or null if not present in the response
     */
    public function result()
    {
        $result = $this->response()->result ?? null;
        if(empty($result))
            $result = $this->response()->results ?? null;

        return $result;
    }

    /**
     * Get the corrected result from the API response.
     *
     * @return mixed|null The corrected result or null if not present in the response
     */
    public function resultCorrected()
    {
        return $this->response()->resultCorrected ?? null;
    }

    /**
     * Get the suggestions from the API response.
     *
     * @return mixed|null The suggestions or null if not present in the response
     */
    public function suggestions()
    {
        return $this->response()->suggestions ?? null;
    }

    /**
     * Get the errors from the API response.
     *
     * @return mixed|null The errors or null if not present in the response
     */
    public function errors()
    {
        return $this->data->errors ?? null;
    }
}