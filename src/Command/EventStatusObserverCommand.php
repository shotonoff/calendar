<?php declare(strict_types = 1);

namespace Aulinks\Command;

use LiteCQRS\Bus\DirectCommandBus;
use Monolog\Logger;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Aulinks\CQRS;

/**
 * Class EventStatusObserverCommand
 * @package Aulinks\Command
 */
class EventStatusObserverCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('event:status:observer');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Logger $logger */
        $logger = $this->getContainer()->get(Logger::class);
        $logger->addInfo("Start 'event:status:observer' command");
        /** @var DirectCommandBus $commandBus */
        $commandBus = $this->getContainer()->get(DirectCommandBus::class);
        $commandBus->handle(new CQRS\ChangeStatusCommand(['date' => new \DateTime('now')]));
        $logger->addInfo("Finished 'event:status:observer' command");
    }
}