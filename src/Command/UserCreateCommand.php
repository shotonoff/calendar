<?php declare(strict_types = 1);

namespace Aulinks\Command;

use Aulinks\DTO\UserRequestDTO;
use LiteCQRS\Bus\DirectCommandBus;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Aulinks\CQRS;
use Symfony\Component\Console\Question\Question;

/**
 * Class UserCreateCommand
 * @package Aulinks\Command
 */
class UserCreateCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('user:create')
            ->addArgument("name", InputArgument::REQUIRED, "User name")
            ->addArgument("email", InputArgument::REQUIRED, "Email address")
            ->addArgument("password", InputArgument::OPTIONAL, "Password")
            ->addOption("super", "s", InputOption::VALUE_NONE, "");
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $output->writeln("Username: " . $input->getArgument('name'));

        $question = new Question('Enter password: ');
        $password = $helper->ask($input, $output, $question);

        $dto = new UserRequestDTO();
        $dto->setUsername($input->getArgument('name'));
        $dto->setEmail($input->getArgument('email'));
        $dto->setInviteToken('');
        $dto->setAdmin($input->getOption('super'));
        $dto->setPassword($password);
        $dto->setConfirmPassword($password);

        /** @var DirectCommandBus $commandBus */
        $commandBus = $this->getContainer()->get(DirectCommandBus::class);
        $commandBus->handle(new CQRS\UserCreateCommand([
            'userDTO' => $dto,
            'inviteCheckSkip' => true
        ]));
    }
}