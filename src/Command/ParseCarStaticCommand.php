<?php

namespace App\Command;

use App\Entity\CarGeneration;
use App\Entity\CarMark;
use App\Entity\CarModel;
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

        $abByLink = 'https://av.by/';

        $crawler = $this->client->request('GET', $abByLink);

        $markList = $crawler->filter('ul.catalog__items li a')->each(function (Crawler $node) {
            return array(
                'link' => $node->attr('href'),
                'name' => trim($node->filter('span')->text())
            );
        });

        $count = 0;

        foreach ($markList as $mark) {
            $link = $mark['link'];

            // save to database
            $carMark = new CarMark();
            $carMark->setAvByLinkName($link);
            $carMark->setName($mark['name']);

            $modelCrawler = $this->client->request('GET', $link);

            $modelList = $modelCrawler->filter('ul.catalog__items li a')->each(function (Crawler $node) {
                return array(
                    'link' => 'https://cars.av.by' . $node->attr('href'),
                    'name' => trim($node->filter('span')->text())
                );
            });

            foreach ($modelList as $model) {
                $carModel = new CarModel();
                $carModel->setName($model['name']);
                $carModel->setAvByLinkName($model['link']);
                $carModel->setMark($carMark);

                $generationCrawler = $this->client->request('GET', $model['link']);

                $generationList = $generationCrawler->filter('.dropdown__card')->each(function (Crawler $node) {
                    if (trim($node->text()) !== 'Поколение') {
                        return trim($node->text());
                    }
                    return array(
                        'error' => 'Not found generationList!'
                    );
                });
                dump($generationList);

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

//            dump($count);
//
//            if ($count === 3) {
//                break;
//            }
        }
        $this->entityManager->flush();

        $executionEndTime = microtime(true);

        // Result time of executing script
        $seconds = $executionEndTime - $executionStartTime;
        echo "This script took $seconds to execute.\n";
    }
}
