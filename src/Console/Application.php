<?php declare(strict_types = 1);

namespace Aulinks\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Interop\Container\ContainerInterface;

/**
 * Class Application
 * @package Aulinks\Console
 */
class Application extends BaseApplication
{
    /** @var ContainerInterface */
    private $container;

    /**
     * Application constructor.
     * @param ContainerInterface $container
     * @param string $name
     * @param string $version
     */
    public function __construct(ContainerInterface $container, $name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct($name, $version);
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}