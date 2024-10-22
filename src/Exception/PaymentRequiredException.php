<?php

declare(strict_types=1);

namespace Foxentry\Exception;

/**
 * Class PaymentRequiredException
 *
 * This exception is thrown when payment is required to access a service or resource.
 * It represents a 402 Payment Required status code.
 *
 * @package Foxentry\Exception
 */
final class PaymentRequiredException extends FoxentryException
{
    /**
     * The HTTP status code associated with this exception.
     *
     */
    protected int $code = 402;
}
