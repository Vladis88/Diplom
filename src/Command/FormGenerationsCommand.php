<?php

namespace App\Command;

use App\Entity\CarGeneration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FormGenerationsCommand
 * @package App\Command
 */
class FormGenerationsCommand extends Command
{
    protected static $defaultName = 'app:form-generations';

    private const YEARS_INTERVAL_REGEX = "/^[1-9][0-9]{3}-[1-9][0-9]{3}$/m";

    private const YEARS_INTERVAL_WITH_STRING_REGEX = "/^[1-9][0-9]{3}-н.в.$/m";

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * FormGenerationsCommand constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }


    protected function configure()
    {
        $this
            ->setDescription('This command should form correct generations');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generations = $this->entityManager->getRepository(CarGeneration::class)->findAll();

        /** @var CarGeneration $generation */
        foreach ($generations as $generation) {
            $array = explode(',', $generation->getName());
            $lastElement = trim($array[count($array) - 1]);

            unset($array[count($array) - 1]);

            $resultString = implode(",", $array);

            $yearsArray = explode('…', $lastElement);

            $fromYear = $yearsArray[0];
            $toYear = $yearsArray[1];

            $fromYearDate = \DateTime::createFromFormat('Y', $fromYear);
            $toYearDate = \DateTime::createFromFormat('Y', $toYear);

            $generation->setName($resultString);
            $generation->setFromYear($fromYear !== '' ? $fromYearDate : new \DateTime('now'));
            $generation->setToYear($toYear !== '' ? $toYearDate : new \DateTime('now'));
        }

        $this->entityManager->flush();
    }
}
