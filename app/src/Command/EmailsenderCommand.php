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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(
    name: 'app:emailsender',
    description: 'Add a short description for your command',
)]
class EmailsenderCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command e-mail sender');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $em = $this->entityManager;
        $sql = 'SELECT users.username, users.email, users.validts FROM users 
        JOIN (SELECT * FROM emails WHERE checked = TRUE and valid = TRUE) AS active_emails ON (users.email = active_emails.email)
        JOIN (SELECT * FROM users WHERE users.confirmed = TRUE AND users.validts < ? ) AS confirmed_users ON (confirmed_users.email = active_emails.email)';
        
        $emails = $em->getConnection()->executeQuery($sql, [strtotime("3 days")])->fetchAllAssociative();

        if (isset($emails))
        {        
            foreach ($emails as $value) 
            {
                $io->text($value['email']);
                $io->text(date('d M Y H:i:s',$value['validts']));

                $email = (new Email())
                ->from('emailsender_for_test@rambler.ru')
                ->to($value['email'])
                ->subject('Subscription is expiring')
                ->text($value['username'] . ', your subscription is expiring soon');

                $mailer = $this->mailer;
                $mailer->send($email);
            }

            return Command::SUCCESS;
        }
        else
        {
            return Command::FAILURE;
        }
    }
}
