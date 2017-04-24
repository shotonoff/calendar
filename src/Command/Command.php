<?php declare(strict_types = 1);

namespace Aulinks\Command;

use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;

/**
 * Class Command
 * @package Aulinks\Console\Command
 */
class Command extends BaseCommand
{
    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->getApplication()->getContainer();
    }
}