<?php

namespace Foxentry\Exception;

/**
 * Class NotFoundException
 *
 * This exception is thrown when a resource or endpoint is not found on the server.
 * It represents a 404 Not Found status code.
 *
 * @package Foxentry\Exception
 */
final class NotFoundException extends FoxentryException
{
    /**
     * The HTTP status code associated with this exception.
     *
     * @var int
     */
    protected $code = 404;
}