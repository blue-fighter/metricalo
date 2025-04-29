<?php

namespace App\Infrastructure\Presentation\Cli;

use App\Application\Factory\PurchaseRequestFactoryInterface;
use App\Application\UseCase\ExecuteChargeUseCase;
use App\Infrastructure\Presentation\Request\OneTimePurchaseRequest;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'app:purchase',
    description: 'Process a one time purchase',
)]
class OneTimePurchaseCommand extends Command
{
    public function __construct(
        private ValidatorInterface $validator,
        private readonly ExecuteChargeUseCase $useCase,
        private readonly PurchaseRequestFactoryInterface $chargeRequestFactory,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp($this->getCommandHelp())
            ->addArgument('gateway', InputArgument::REQUIRED, 'aci|shift4')
            ->addOption('amount', null, InputOption::VALUE_REQUIRED, 'The payment amount (e.g. 10050)')
            ->addOption('currency', null, InputOption::VALUE_REQUIRED, 'The currency code (e.g. USD, EUR)')
            ->addOption('cardNumber', null, InputOption::VALUE_REQUIRED, 'Credit card number')
            ->addOption('cardExpYear', null, InputOption::VALUE_REQUIRED, 'Card expiration year (2 digits)')
            ->addOption('cardExpMonth', null, InputOption::VALUE_REQUIRED, 'Card expiration month (1-12)')
            ->addOption('cardCVV', null, InputOption::VALUE_REQUIRED, 'Card security code (3 digits)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $gateway = $input->getArgument('gateway');

        $request = new OneTimePurchaseRequest(
            amount: $input->getOption('amount'),
            currency: $input->getOption('currency'),
            cardNumber: $input->getOption('cardNumber'),
            cardExpYear: $input->getOption('cardExpYear'),
            cardExpMonth: $input->getOption('cardExpMonth'),
            cardCVV: $input->getOption('cardCVV'),
        );
        // Retrieve all input values

        $violations = $this->validator->validate($request);
        if (count($violations)) {
            array_map(static fn(ConstraintViolation $e) => $io->writeln(
                sprintf(
                    '%s: %s',
                    $e->getPropertyPath(),
                    $e->getMessage(),
                ),
            ));
            return Command::FAILURE;
        }

        $purchaseRequest = $this->chargeRequestFactory->create(
            expireMonth: $request->getCardExpMonth(),
            expireYear: $request->getCardExpYear(),
            amount: $request->getAmount(),
            currency: $request->getCurrency(),
            number: $request->getCardNumber(),
            cvv: $request->getCardCVV(),
        );


        $result = $this->useCase->execute($gateway, $purchaseRequest);
        // Here you would typically call your payment processor service
        // $paymentResult = $this->paymentService->process(...);
        // Process payment (this would call your payment service)
        $io->definitionList(
            ['transactionId' => $result->getTransactionId()],
            ['dateOfCreating' => $result->getCreationDate()],
            ['amount' => $result->getAmount()],
            ['currency' => $result->getCurrency()],
            ['cardBin' => $result->getCardBin()],
        );
        $io->success('Payment processed successfully!');
        return Command::SUCCESS;
    }

    private function getCommandHelp(): string
    {
        return <<<'HELP'
The <info>%command.name%</info> command processes a payment transaction.

<comment>Basic Usage:</comment>
  <info>php bin/console %command.name% GATEWAY [options]</info>

<comment>Required Arguments:</comment>
  <info>GATEWAY</info>      The payment gateway (aci|shift4)

<comment>Required Options:</comment>
  <info>--amount</info>         The payment amount (e.g. 100.50)
  <info>--currency</info>       The currency code (e.g. USD, EUR)
  <info>--cardNumber</info>     Credit card number (16 digits)
  <info>--cardExpYear</info>    Card expiration year (2 digits)
  <info>--cardExpMonth</info>   Card expiration month (1-12)
  <info>--cardCVV</info>        Card security code (3 digits)

<comment>Examples:</comment>
  Process a $100 payment:
  <info>php bin/console %command.name% aci --amount 10000 --currency USD --cardNumber=4111111111111111 --cardExpYear=29 --cardExpMonth=2 --cardCVV=123</info>

  Process a €50 payment:
  <info>php bin/console %command.name% shift4 --amount 500 --currency EUR --cardNumber=5555555555554444 --cardExpYear=2025 --cardExpMonth=11 --cardCVV=456</info>
HELP;
    }
}
