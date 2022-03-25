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
    private $em;

    /**
     * FormGenerationsCommand constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }


    protected function configure()
    {
        $this
            ->setDescription('This command should form correct generations');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generations = $this->em->getRepository(CarGeneration::class)->findAll();

        /** @var CarGeneration $generation */
        foreach ($generations as $generation) {
            $array = explode(',', $generation->getName());
            $lastElement = trim($array[count($array) - 1]);

            unset($array[count($array) - 1]);

            $resultString = implode(",", $array);

            dump($resultString);

            $yearsArray = explode('—', $lastElement);

            $fromYear = $yearsArray[0];
            $toYear = $yearsArray[1];

            $fromYearDate = \DateTime::createFromFormat('Y', $fromYear);
            $toYearDate = \DateTime::createFromFormat('Y', $toYear);

            $generation->setName($resultString);
            $generation->setFromYear($fromYear !== 'н.в.' ? $fromYearDate : new \DateTime('now'));
            $generation->setToYear($toYear !== 'н.в.' ? $toYearDate : new \DateTime('now'));
        }

        $this->em->flush();
    }
}
