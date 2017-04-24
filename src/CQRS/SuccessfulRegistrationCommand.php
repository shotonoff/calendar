<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use LiteCQRS\DefaultCommand;

/**
 * Class SuccessfulRegistrationCommand
 * @package Aulinks\CQRS
 */
class SuccessfulRegistrationCommand extends DefaultCommand
{
    /** @var string */
    public $email;

    /** @var string */
    public $username;
}