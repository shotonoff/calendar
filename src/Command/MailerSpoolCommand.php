<?php declare(strict_types = 1);

namespace Aulinks\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MailerSpoolCommand
 * @package Aulinks\Console\Command
 */
class MailerSpoolCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('mailer:send')
            ->addOption('message-limit', null, InputOption::VALUE_OPTIONAL, 10)
            ->addOption('time-limit', null, InputOption::VALUE_OPTIONAL, 600)
            ->addOption('recover-timeout', null, InputOption::VALUE_OPTIONAL, 900)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $realTransport = $this->getContainer()->get(\Swift_SendmailTransport::class);
        $mailer = $this->getContainer()->get(\Swift_Mailer::class);
        $transport = $mailer->getTransport();

        if (!$transport instanceof \Swift_Transport_SpoolTransport) {
            return;
        }

        $spool = $transport->getSpool();
        if ($spool instanceof \Swift_ConfigurableSpool) {
            $spool->setMessageLimit($input->getOption('message-limit'));
            $spool->setTimeLimit($input->getOption('time-limit'));
        }
        if ($spool instanceof \Swift_FileSpool) {
            if (null !== $input->getOption('recover-timeout')) {
                $spool->recover($input->getOption('recover-timeout'));
            } else {
                $spool->recover();
            }
        }
        $sent = $spool->flushQueue($realTransport);
        $output->writeln(sprintf('sent %s emails', $sent));
    }
}