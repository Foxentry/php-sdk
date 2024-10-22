<?php

declare(strict_types=1);

namespace Foxentry\Exception;

/**
 * Class TooManyRequestsException
 *
 * This exception is thrown when there are too many requests made in a given time frame.
 * It represents a 429 Too Many Requests status code.
 *
 * @package Foxentry\Exception
 */
final class TooManyRequestsException extends FoxentryException
{
    /**
     * The HTTP status code associated with this exception.
     *
     * @var int
     */
    // Native typehint missing, because definition needs to match the native Exception class.
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $code = 429;
}
