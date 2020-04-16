<?php

namespace App\Command;

use App\Service\Reminder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ReminderCommand extends Command
{
    protected static $defaultName = 'app:reminder';
    protected $reminder;

    public function __construct(?string $name = null, Reminder $reminder)
    {
        parent::__construct($name);
        $this->reminder = $reminder;

    }

    protected function configure()
    {
        $this
            ->setDescription('Envoie aux utilisateurs les rappels de leurs tâche');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $output->writeln([
            "Reminder",
            "--------",
            ""
        ]);

        $reminds = $this->reminder->remind();

        $io->success($reminds . ' rappels ont été envoyés');
        return 0;
    }
}
