<?php

namespace AppBundle\Command;

use AppBundle\ElectedRepresentativesRegister\ElectedRepresentativesRegisterLoader;
use AppBundle\Entity\ElectedRepresentativesRegister;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportElectedRepresentativesRegisterCommand extends Command
{
    protected static $defaultName = 'app:elected-representatives-register:import';

    /**
     * @var SymfonyStyle
     */
    private $io;

    private $loader;

    public function __construct(ElectedRepresentativesRegisterLoader $loader)
    {
        $this->loader = $loader;
        parent::__construct();
    }


    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'CSV file of all elected to load');
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->text('Start importing Elected');

        $this->loader->load($input->getArgument('file'));

        $this->io->success('Done');
    }
}
