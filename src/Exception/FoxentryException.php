<?php

declare(strict_types=1);

namespace Foxentry\Exception;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

/**
 * Foxentry exception handler
 *
 * @package Foxentry\Exception
 */
class FoxentryException extends \Exception
{
    protected ?ResponseInterface $response = null;

    /**
     * Create a FoxentryException based on the given RequestException.
     *
     */
    public static function fromRequestException(RequestException $e): self
    {
        // Check if the exception has a response
        if ($e->hasResponse()) {
            $statusCode = $e->getResponse()?->getStatusCode() ?? -1;
            // Switch based on the status code of the response
            switch ($statusCode) {
                case 400:
                    $foxentryException = new BadRequestException('Request was invalid or cannot be processed.');
                    break;
                case 401:
                    $foxentryException = new UnauthorizedException('Unauthorized. Did you set your API key?');
                    break;
                case 402:
                    $foxentryException = new PaymentRequiredException('Payment is required to access this resource.');
                    break;
                case 403:
                    $foxentryException = new ForbiddenException('Forbidden.');
                    break;
                case 404:
                    $foxentryException = new NotFoundException('Resource or endpoint requested is not found on the server.');
                    break;
                case 429:
                    $foxentryException = new TooManyRequestsException(
                        'Too many requests have been made in the given time frame or the daily limit has been reached.'
                    );
                    break;
                case 500:
                    $foxentryException = new ServerErrorException('Internal server error.');
                    break;
                case 503:
                    $foxentryException = new ServiceUnavailableException('The server is temporarily unable to handle the request');
                    break;
                default:
                    // Handle the rest with generic FoxentryException class
                    $foxentryException = new self('Request exception: ' . $e->getMessage(), $statusCode);
                    break;
            }

            return  $foxentryException->setResponse($e->getResponse());
        }

        // Return a generic exception with the original exception message
        return new self('Exception: ' . $e->getMessage());
    }

    public function setResponse(?ResponseInterface $response): self
    {
        $this->response = $response;
        return $this;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
