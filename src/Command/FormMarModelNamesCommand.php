<?php

namespace App\Command;

use App\Entity\CarMark;
use App\Entity\CarModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FormMarModelNamesCommand
 * @package App\Command
 */
class FormMarModelNamesCommand extends Command
{
    protected static $defaultName = 'app:mark-model-form';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * FormMarModelNamesCommand constructor.
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
            ->setDescription('This command should form model and mark names from av.by links and save them to database');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->formMarkNames();
        $this->formModelNames();
    }

    private function formMarkNames()
    {
        $marks = $this->em->getRepository(CarMark::class)->findAll();

        /** @var CarMark $mark */
        foreach ($marks as $mark) {
            $avByLink = $mark->getAvByLinkName();

            $path = parse_url($avByLink, PHP_URL_PATH);
            $markNameFromLink = explode('/', $path)[1];

            $mark->setNameFromLink($markNameFromLink);
        }

        $this->em->flush();
    }

    private function formModelNames()
    {
        $models = $this->em->getRepository(CarModel::class)->findAll();

        /** @var CarModel $model */
        foreach ($models as $model) {
            $avByLink = $model->getAvByLinkName();

            $path = parse_url($avByLink, PHP_URL_PATH);
            $modelNameFromLink = explode('/', $path)[2];

            $model->setNameFromLink($modelNameFromLink);
        }

        $this->em->flush();
    }
}
