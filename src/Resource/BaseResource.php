<?php

namespace Foxentry\Resource;

use Foxentry\Request;
use Foxentry\Response;

/**
 * Base resource class for handling common resource functionality.
 *
 * @package Foxentry\Resource
 */
class BaseResource
{
    protected Request $request;

    /**
     * Constructor to initialize the resource with a request object.
     *
     * @param Request $request The request object for making API requests
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Include request details in API responses.
     *
     * @param bool $value Whether to include request details (default: true)
     */
    public function includeRequestDetails( bool $value = true ): self {
        $this->request->setHeader( "Foxentry-Include-Request-Details", $value );
        return $this;
    }

    /**
     * Set a custom ID for the resource.
     *
     * @param string $id The custom ID to set
     *
     * @return BaseResource Returns $this for method chaining
     */
    public function setCustomId(string $id): BaseResource
    {
        $this->request->setCustomId($id);
        return $this;
    }

    /**
     * Set options for the resource request.
     *
     * @param array $options The options to set
     *
     * @return BaseResource Returns $this for method chaining
     */
    public function setOptions(array $options): BaseResource
    {
        $this->request->setOptions($options);
        return $this;
    }

    /**
     * Set the client's IP address for the resource request.
     *
     * @param string $ip The client IP address
     *
     * @return BaseResource Returns $this for method chaining
     */
    public function setClientIP(string $ip): BaseResource
    {
        $this->request->setClientIP($ip);
        return $this;
    }

    /**
     * Set the client's country information for the resource request.
     *
     * @param string $country The client country code in format ISO-3166-1 alpha-2.
     *
     * @return BaseResource Returns $this for method chaining
     * @see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2 ISO-3166-1 alpha-2 country code format
     */
    public function setClientCountry(string $country): BaseResource
    {
        $this->request->setClientCountry($country);
        return $this;
    }

    /**
     * Set the client's location information for the resource request.
     *
     * @param float $lon The client's longitude
     * @param float $lat The client's latitude
     *
     * @return BaseResource Returns $this for method chaining
     */
    public function setClientLocation(float $lat, float $lon): BaseResource
    {
        $this->request->setClientLocation($lat, $lon);
        return $this;
    }

    /**
     * Send a request to the API with the given query parameters.
     *
     * @param array $query The query parameters for the request
     *
     * @return Response The response from the API
     * @throws \Exception
     */
    protected function send(array $query): Response
    {
        $endpoint = $this->getCallerEndpoint();
        $this->request->setEndpoint($endpoint);
        $this->request->setQuery($query);
        return $this->request->send();
    }

    /**
     * Get the endpoint based on the caller class and method.
     *
     * @return string The calculated endpoint string
     */
    private function getCallerEndpoint(): string
    {
        $class = get_called_class();
        $class = substr($class, strrpos($class, '\\') + 1);
        $class = strtolower($class);

        $method = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 4)[3]['function'];
        return "$class/$method";
    }
}
