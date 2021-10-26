<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Services\CoinMarketCapService;
use App\Services\CronService;
use App\Services\CryptoService;
use App\Services\TransactionService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class TestCommand extends Command
{

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:test';

    protected function configure(): void
    {
        $this
            ->setDescription('Ajoute dans la base de données, quotidiennement, les valorisations pour chaque utilisateurs')
            ->setHelp('Ajoute dans la base de données, quotidiennement, les valorisations pour chaque utilisateurs');
    }



    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $coinMarketCapService = new CoinMarketCapService($coinMarketCapService->client);
        $transactionService = new TransactionService();
        $cryptoService = new CryptoService();

        $cron = new CronService();
        $cron->addSoldeForEachUser($coinMarketCapService, $transactionService, $cryptoService);

        $output->writeln("La cron a bien été lancée");

    }
}