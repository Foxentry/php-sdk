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
     * Data in the response.
     *
     * @var mixed
     */
    private $data;

    /**
     * Headers of the response.
     *
     * @var array
     */
    private array $headers = [];

    /**
     * Response constructor.
     *
     * @param mixed $response The response data
     * @param array $headers The response headers
     */
    public function __construct($response, array $headers)
    {
        if (!is_object($response)) {
            $response = json_decode($response);
        }

        $this->headers = $headers;
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
     * Get headers received from the API response.
     *
     * @return array Response headers
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Get request rate limit.
     *
     * @return int Rate limit number
     */
    public function getRateLimit(): int {
        return reset($this->headers['foxentry-rate-limit']);
    }

    /**
     * Get reset period of request rate limit
     *
     * @return int Time period in seconds of how long it will take before the rate limit is restored
     */
    public function getRateLimitPeriod(): int {
        return reset($this->headers['foxentry-rate-limit-period']);
    }

    /**
     * Get remaining request rate limit.
     *
     * @return int Remaining rate limit
     */
    public function getRateLimitRemaining(): int {
        return reset($this->headers['foxentry-rate-limit-remaining']);
    }

    /**
     * Get remaining daily credits.
     *
     * @return float Remaining daily credits
     */
    public function getDailyCreditsLeft(): float {
        return reset($this->headers['foxentry-daily-credits-left']);
    }

    /**
     * Get daily credits limit.
     *
     * @return int Daily credits limit
     */
    public function getDailyCreditsLimit(): int {
        return reset($this->headers['foxentry-daily-credits-limit']);
    }

    /**
     * Get version of the API that has been used for the request.
     *
     * @return float API version
     */
    public function getApiVersion(): float {
        return reset($this->headers['foxentry-api-version']);
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