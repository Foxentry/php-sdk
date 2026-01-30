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
 * Phone resource class for validating phone numbers.
 *
 * @package Foxentry\Resource
 */
final class Phone extends BaseResource
{
    /**
     * Validate a phone number.
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
