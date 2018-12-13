<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\ProgressBar;


class Users extends Command
{
    protected $pdo;
    protected $faker;

    public function __construct($pdo, $faker)
    {
        parent::__construct();
        $this->pdo = $pdo;
        $this->faker = $faker;
    }

    protected function configure()
    {
        $this->setName('seed:users')
            ->setDescription("Send fakers users")
            ->setHelp('This command will send fakers users')
            ->addOption('count', 'c', InputOption::VALUE_REQUIRED, 'How many users would you like to add ?', 1);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<fg=black;bg=magenta>Whaaaouuuu you send {$input->getOption("count")} users</>");
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $email = $this->faker->email;
        $progressBar = new ProgressBar($output, $input->getOption("count"));
        $progressBar->start();
        for ($i = 0; $i < $input->getOption("count"); $i++) {
            $this->pdo->query("INSERT INTO users (first_name, last_name, email) VALUES ('{$firstName}', '{$lastName}', '{$email}')");
            $progressBar->advance();
        }
        $progressBar->finish();
    }
}






