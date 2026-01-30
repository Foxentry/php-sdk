<?php

declare(strict_types=1);

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
    // Native typehint missing, because definition needs to match the native Exception class.
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $code = 403;
}
