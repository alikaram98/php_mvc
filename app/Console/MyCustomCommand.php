<?php

declare(strict_types=1);

namespace App\Console;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:my-command')]
class MyCustomCommand extends Command
{
    public function __construct(ContainerInterface $container)
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('message for testing');
        return Command::SUCCESS;
    }
}
