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
use Foxentry\Response;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Location resource class for validating, searching, and retrieving information about addresses
 *
 * @package Foxentry\Resource
 */
final class Location extends BaseResource
{
    /**
     * Validate an address.
     *
     * @param array<string, mixed> $query Query parameters for the validation request
     *
     * @return Response The response from the validation request
     *
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
    public function validate(array $query): Response
    {
        return $this->sendRequest($query);
    }

    /**
     * Search for a location.
     *
     * @param array<string, mixed> $query Query parameters for the search request
     *
     * @return Response The response from the API
     *
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
    public function search(array $query): Response
    {
        return $this->sendRequest($query);
    }

    /**
     * Get location details.
     *
     * @param array<string, mixed> $query Query parameters for the get request
     *
     * @return Response The response from the API
     *
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
    public function get(array $query): Response
    {
        return $this->sendRequest($query);
    }

    /**
     * Localize a location.
     *
     * @param array<string, mixed> $query Query parameters for the localize request
     *
     * @return Response The response from the API
     *
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
    public function localize(array $query): Response
    {
        return $this->sendRequest($query);
    }

    /**
     * Send a request to the API with the given query parameters.
     *
     * @param array<string, mixed> $query Query parameters for the request
     *
     * @return Response The response from the API
     *
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
    private function sendRequest(array $query): Response
    {
        return $this->send($query);
    }
}
