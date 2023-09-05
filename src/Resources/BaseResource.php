<?php

namespace Foxentry\Resources;

use Foxentry\Request;
use Foxentry\Response;

/**
 * Base resource class for handling common resource functionality.
 *
 * @package Foxentry\Resources
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
     * Set client information for the resource request.
     *
     * @param string|null $ip The client IP address
     * @param mixed|null $country The client country information
     * @param array|null $location The client location information. Specify as array with "lat" and "lon" properties!
     *
     * @return BaseResource Returns $this for method chaining
     */
    public function setClient(string $ip = null, string $country = null, array $location = null): BaseResource
    {
        $this->request->setClient($ip, $country, $location);
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