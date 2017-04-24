<?php declare(strict_types = 1);

namespace Aulinks\Slim;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;

/**
 * Class Application
 * @package Aulinks\DI
 */
class Application extends App
{
    /** @var array */
    private $definitions;

    /** @var array */
    private $config;

    /**
     * Application constructor.
     * @param array $config
     * @param array $definitions
     */
    public function __construct(array $config, array $definitions)
    {
        $this->config = $config;
        $this->definitions = $definitions;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->addDefinitions([
            'settings.responseChunkSize' => 4096,
            'settings.outputBuffering' => 'append',
            'settings.determineRouteBeforeAppMiddleware' => false,
            'settings.displayErrorDetails' => true,
            'settings.addContentLengthHeader' => false,
        ]);
        $builder->addDefinitions($this->config);
        $builder->addDefinitions($this->definitions);
    }
}