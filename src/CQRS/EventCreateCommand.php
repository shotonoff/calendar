<?php declare(strict_types = 1);

namespace Aulinks\CQRS;

use LiteCQRS\DefaultCommand;

/**
 * Class EventCreateCommand
 * @package Aulinks\CRQS
 */
class EventCreateCommand extends DefaultCommand
{
    /**
     * @var string|array
     */
    public $data;
}