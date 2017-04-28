<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use LiteCQRS\DefaultCommand;

/**
 * Class ChangeStatusCommand
 * @package Aulinks\CQRS
 */
class ChangeStatusCommand extends DefaultCommand
{
    /** @var \DateTimeInterface */
    public $date;
}