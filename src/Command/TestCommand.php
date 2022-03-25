<?php

namespace App\Command;

use App\Service\Payment\PaymentService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TestCommand
 */
class TestCommand extends Command
{
    protected static $defaultName = 'app:test';

    /**
     * @var PaymentService
     */
    private $paymentService;

    /**
     * TestCommand constructor.
     * @param PaymentService $paymentService
     */
    public function __construct(PaymentService $paymentService)
    {
        parent::__construct();
        $this->paymentService = $paymentService;
    }


    protected function configure()
    {
        $this->setDescription('Test command');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->paymentService->pay();
    }
}
