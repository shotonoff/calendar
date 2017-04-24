<?php declare(strict_types = 1);

namespace Aulinks\Exception;

/**
 * Class ForbiddenException
 * @package Aulinks\Exception
 */
class ForbiddenException extends \RuntimeException
{
    /**
     * @return ForbiddenException
     */
    public static function invalidEventOwner(): ForbiddenException
    {
        return new static('Invalid event owner');
    }
}