<?php
namespace Foxentry\Exception;

use GuzzleHttp\Exception\RequestException;

/**
 * Foxentry exception handler
 *
 * @package Foxentry\Exception
 */
class FoxentryException extends \Exception
{
    /**
     * Create a FoxentryException based on the given RequestException.
     *
     * @param RequestException $e
     */
    public static function fromRequestException(RequestException $e)
    {
        // Check if the exception has a response
        if ($e->hasResponse()) {
            $statusCode = $e->getResponse()->getStatusCode();

            // Switch based on the status code of the response
            switch ($statusCode) {
                case 400:
                    return new BadRequestException("Request was invalid or cannot be processed.");
                case 401:
                    return new UnauthorizedException("Unauthorized. Did you set your API key?");
                case 402:
                    return new PaymentRequiredException("Payment is required to access this resource.");
                case 403:
                    return new ForbiddenException("Forbidden.");
                case 404:
                    return new NotFoundException("Resource or endpoint requested is not found on the server.");
                case 429:
                    return new TooManyRequestsException("Too many requests have been made in the given time frame or the daily limit has been reached.");
                case 500:
                    return new ServerErrorException("Internal server error.");
                case 503:
                    return new ServiceUnavailableException("The server is temporarily unable to handle the request");
                default:
                    // Handle the rest with generic FoxentryException class
                    return new self("Request exception: " . $e->getResponse()->getBody()->getContents(), $statusCode);
            }
        } else {
            // Return a generic exception with the original exception message
            return new self("Exception: " . $e->getMessage());
        }
    }
}