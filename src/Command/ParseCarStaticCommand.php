<?php

namespace App\Command;

use App\Entity\CarGeneration;
use App\Entity\CarMark;
use App\Entity\CarModel;
use Behat\Mink\Driver\DriverInterface;
use Behat\Mink\Session;
use Doctrine\ORM\EntityManagerInterface;
use Goutte\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class ParseCarStaticCommand
 * @package App\Command
 */
class ParseCarStaticCommand extends Command
{

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var string
     */
    protected static $defaultName = 'app:parse-car-static';

    /**
     * ParseCarStaticCommand constructor.
     * @param Client $client
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(Client $client, EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->client = $client;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('This command extract all mark, models and generations for cars');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // fix start time for parsing
        $executionStartTime = microtime(true);

        $abApiByLink = 'https://api.av.by/offer-types/cars/landings';


        $markJson = file_get_contents($abApiByLink);
        $markJsonArr = json_decode($markJson, true);


        $markList = $markJsonArr['seo']['links'];

        $count = 0;

        foreach ($markList as $mark) {
            $arrayPartLink = explode('/', $mark['url']);
            $linkMark = $abApiByLink . '/' . $arrayPartLink[count($arrayPartLink) - 1];

            // save to database
            $carMark = new CarMark();
            $carMark->setAvByLinkName($mark['url']);
            $carMark->setName($mark['label']);

            $modelJson = file_get_contents($linkMark);
            $modelJsonArr = json_decode($modelJson, true);

            $modelList = $modelJsonArr['seo']['links'];

            foreach ($modelList as $model) {
                $carModel = new CarModel();
                $carModel->setName($model['label']);
                $carModel->setAvByLinkName($model['url']);
                $carModel->setMark($carMark);

                $generationCrawler = $this->client->request('GET', $model['url']);

                $generationList = $generationCrawler->filter('.dropdown__card')->each(function (Crawler $node) {
                    if (trim($node->text()) !== 'Поколение') {
                        return trim($node->text());
                    }
                    return array(
                        'error' => 'Not found generationList!'
                    );
                });

                foreach ($generationList as $generation) {
                    if ($generation !== null) {
                        $carGeneration = new CarGeneration();
                        $carGeneration->setName($generation);
                        $carGeneration->setModel($carModel);
                        $this->entityManager->persist($carGeneration);
                    }
                }

                $this->entityManager->persist($carModel);
            }

            $this->entityManager->persist($carMark);

            $count++;

            dump($count);

            if ($count === 5) {
                break;
            }
        }
        $this->entityManager->flush();

        $executionEndTime = microtime(true);

        // Result time of executing script
        $seconds = $executionEndTime - $executionStartTime;
        echo "This script took $seconds to execute.\n";
    }
}
