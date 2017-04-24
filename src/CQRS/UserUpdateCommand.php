<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use LiteCQRS\DefaultCommand;

/**
 * Class UserUpdateCommand
 * @package Aulinks\CRQS
 */
class UserUpdateCommand extends DefaultCommand
{
    /** @var string|array */
    public $data;
}