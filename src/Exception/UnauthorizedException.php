<?php

declare(strict_types=1);

namespace Foxentry\Exception;

/**
 * Class UnauthorizedException
 *
 * This exception is thrown when the request is unauthorized.
 * Usually triggered when API authentication fails or an invalid API key is used.
 *
 * @package Foxentry\Exception
 */
final class UnauthorizedException extends FoxentryException
{
    /**
     * The HTTP status code associated with this exception.
     *
     */
    protected int $code = 401;
}
