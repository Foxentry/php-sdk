<?php

namespace Foxentry\Exception;

/**
 * Class ForbiddenException
 *
 * This exception is thrown when access to a resource is forbidden for the current user or client.
 * It represents a 403 Forbidden status code.
 *
 * @package Foxentry\Exception
 */
final class ForbiddenException extends FoxentryException
{
    /**
     * The HTTP status code associated with this exception.
     *
     * @var int
     */
    protected $code = 403;
}
