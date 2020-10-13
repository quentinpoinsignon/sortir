<?php

namespace App\Command;

use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\Exception\DriverException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class IrrationalIdResetCommand extends Command
{
    protected static $defaultName = 'irrational-id-reset';
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Breathe.Relax.Your database id\'s are now nice and sweet')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Table name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $conn = $this->entityManager->getConnection();
            $sql = 'ALTER TABLE '. $arg1 .' AUTO_INCREMENT = 0;';

            try {
                $stmt = $conn->prepare($sql);
            } catch (\Doctrine\DBAL\Exception $e) {
                //here I would like to make a custom $io->error but it doesn't work
            }

            try {
                $stmt->execute();
                $io->success('The ids of your '. $arg1 . ' table has been reset to the lowest possible value, sleep well now.');
                return Command::SUCCESS;
            } catch (DriverException $e) {
                $io->error('Something went wrong, please check you passed the right argument.');
                return Command::FAILURE;
            }
        }
        else
        {
            $io->error('Something went wrong, please check you passed the right argument.');
            return Command::SUCCESS;
        }



    }
}
