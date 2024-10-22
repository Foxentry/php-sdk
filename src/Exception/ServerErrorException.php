<?php

declare(strict_types=1);

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
    // Native typehint missing, because definition needs to match the native Exception class.
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $code = 500;
}
