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
 * Email resource class for validating and searching email addresses.
 *
 * @package Foxentry\Resource
 */
final class Email extends BaseResource
{
    /**
     * Validate an email address.
     *
     * @param string|array<string, mixed> $query Email address to validate
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
    public function validate(string|array $query): Response
    {
        $query = is_array($query) ? $query : ['email' => $query];
        return $this->sendRequest($query);
    }

    /**
     * Search for information related to an email address.
     *
     * @param string|array<string, mixed> $query Email address to search for
     *
     * @return Response The response from the search request
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
    public function search(string|array $query): Response
    {
        $query = is_array($query) ? $query : ['value' => $query];
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
