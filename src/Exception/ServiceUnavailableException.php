<?php

declare(strict_types=1);

namespace Foxentry\Exception;

/**
 * Class ServiceUnavailableException
 *
 * This exception is thrown when the service or endpoint is temporarily unavailable.
 * It represents a 503 Service Unavailable status code.
 *
 * @package Foxentry\Exception
 */
final class ServiceUnavailableException extends FoxentryException
{
    /**
     * The HTTP status code associated with this exception.
     *
     */
    protected int $code = 503;
}
