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
    private EntityManagerInterface $entityManager;

    /**
     * FormMarModelNamesCommand constructor.
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
            ->setDescription('This command should form model and mark names from av.by links and save them to database');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->formMarkNames();
        $this->formModelNames();
    }

    private function formMarkNames()
    {
        $marks = $this->entityManager->getRepository(CarMark::class)->findAll();

        /** @var CarMark $mark */
        foreach ($marks as $mark) {
            $avByLink = $mark->getAvByLinkName();

            $path = parse_url($avByLink, PHP_URL_PATH);
            $markNameFromLink = explode('/', $path)[1];

            $mark->setNameFromLink($markNameFromLink);
        }

        $this->entityManager->flush();
    }

    private function formModelNames()
    {
        $models = $this->entityManager->getRepository(CarModel::class)->findAll();

        /** @var CarModel $model */
        foreach ($models as $model) {
            $avByLink = $model->getAvByLinkName();

            $path = parse_url($avByLink, PHP_URL_PATH);
            $modelNameFromLink = explode('/', $path)[2];

            $model->setNameFromLink($modelNameFromLink);
        }

        $this->entityManager->flush();
    }
}
