<?php declare(strict_types = 1);

namespace Aulinks\Validator;

use Respect\Validation\Validator as v;
use DavidePastore\Slim\Validation\Validation;

/**
 * Class ValidatorCreator
 * @package Aulinks\Validator
 */
class ValidatorCreator
{
    /**
     * @return Validation
     */
    public static function createEventFeedValidator(): Validation
    {
        return new Validation([
            'start' => v::date('Y-m-d'),
            'end' => v::allOf(
                v::date('Y-m-d')
            )
        ]);
    }

    /**
     * @return Validation
     */
    public static function createEventDataValidator(): Validation
    {
        return new Validation([
            'name' => v::allOf(
                v::alnum(),
                v::min(3)
            ),
            'date' => v::date('Y-m-d H:i:s'),
            'colorHex' => v::hexRgbColor(),
            'status' => v::oneOf(
                v::equals(1),
                v::equals(2),
                v::equals(3)
            ),
            'description' => v::allOf(
                v::alnum(),
                v::max(2000)
            ),
        ]);
    }
}