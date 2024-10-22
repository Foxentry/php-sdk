<?php

declare(strict_types=1);

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
    // Native typehint missing, because definition needs to match the native Exception class.
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $code = 400;
}
