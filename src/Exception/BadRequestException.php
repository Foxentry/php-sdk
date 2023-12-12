<?php

namespace Foxentry\Exception;

/**
 * Class BadRequestException
 *
 * This exception is thrown when the request is invalid or cannot be processed.
 * It represents a 400 Bad Request status code.
 *
 * @package Foxentry\Exception
 */
final class BadRequestException extends FoxentryException
{
    /**
     * The HTTP status code associated with this exception.
     *
     * @var int
     */
    protected $code = 400;
}
