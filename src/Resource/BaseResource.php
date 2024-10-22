<?php

declare(strict_types=1);

namespace Foxentry\Resource;

use Foxentry\Exception\BadRequestException;
use Foxentry\Exception\ForbiddenException;
use Foxentry\Exception\FoxentryException;
use Foxentry\Exception\NotFoundException;
use Foxentry\Exception\PaymentRequiredException;
use Foxentry\Exception\ServerErrorException;
use Foxentry\Exception\TooManyRequestsException;
use Foxentry\Exception\UnauthorizedException;
use Foxentry\Request;
use Foxentry\Response;
use GuzzleHttp\Exception\GuzzleException;

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
    public function includeRequestDetails(bool $value = true): static
    {
        $this->request->setHeader("Foxentry-Include-Request-Details", $value);
        return $this;
    }

    /**
     * Set a custom ID for the resource.
     *
     * @param string $id The custom ID to set
     *
     * @return $this Returns $this for method chaining
     */
    public function setCustomId(string $id): self
    {
        $this->request->setCustomId($id);
        return $this;
    }

    /**
     * Set options for the resource request.
     *
     * @param array<string, mixed> $options The options to set
     *
     * @return $this Returns $this for method chaining
     */
    public function setOptions(array $options): self
    {
        $this->request->setOptions($options);
        return $this;
    }

    /**
     * Set the client's IP address for the resource request.
     *
     * @param string $ip The client IP address
     *
     * @return $this Returns $this for method chaining
     */
    public function setClientIP(string $ip): self
    {
        $this->request->setClientIP($ip);
        return $this;
    }

    /**
     * Set the client's country information for the resource request.
     *
     * @param string $country The client country code in format ISO-3166-1 alpha-2.
     *
     * @return $this Returns $this for method chaining
     * @see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2 ISO-3166-1 alpha-2 country code format
     */
    public function setClientCountry(string $country): self
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
     * @return $this Returns $this for method chaining
     */
    public function setClientLocation(float $lat, float $lon): self
    {
        $this->request->setClientLocation($lat, $lon);
        return $this;
    }

    /**
     * Send a request to the API with the given query parameters.
     *
     * @param array<string, mixed> $query The query parameters for the request
     *
     * @return Response The response from the API
     * @throws TooManyRequestsException
     * @throws BadRequestException
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws PaymentRequiredException
     * @throws ServerErrorException
     * @throws UnauthorizedException
     * @throws FoxentryException
     * @throws GuzzleException
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
