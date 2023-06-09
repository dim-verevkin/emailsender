<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'app:checkemail',
    description: 'Add a short description for your command',
)]
class CheckemailCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command e-mail checker')
        ->addArgument('email', InputArgument::REQUIRED, 'e-mail to be checked');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg = $input->getArgument('email');
        if (isset($arg))
        {
            $em = $this->entityManager;
            $sql = 'UPDATE emails SET checked = TRUE, valid = :valid WHERE email = :email AND NOT checked';
            
            $emails = $em->getConnection()->executeUpdate(
                $sql,
                array(
                    'valid' => boolval(filter_var($arg, FILTER_VALIDATE_EMAIL)),
                    'email' => $arg,
                )
            );
        }

        return Command::SUCCESS;
    }
}
