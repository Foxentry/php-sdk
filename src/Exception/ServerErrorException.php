<?php

namespace Foxentry\Exception;

/**
 * Class ServerErrorException
 *
 * This exception is thrown when the server encounters an internal error.
 * It represents a 500 Internal Server Error status code.
 *
 * @package Foxentry\Exception
 */
final class ServerErrorException extends FoxentryException
{
    /**
     * The HTTP status code associated with this exception.
     *
     * @var int
     */
    protected $code = 500;
}
