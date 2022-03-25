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
    private $client;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var string
     */
    protected static $defaultName = 'app:parse-car-static';

    /**
     * ParseCarStaticCommand constructor.
     * @param Client $client
     * @param EntityManagerInterface $em
     */
    public function __construct(Client $client, EntityManagerInterface $em)
    {
        parent::__construct();

        $this->client = $client;
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('This command extract all mark, models and generations for cars');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // fix start time for parsing
        $executionStartTime = microtime(true);

        $abByLink = 'https://av.by/';

        $crawler = $this->client->request('GET', $abByLink);

        $markList = $crawler->filter('ul.brandslist li a')->each(function (Crawler $node) {
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

            $modelList = $modelCrawler->filter('ul.brandslist li a')->each(function (Crawler $node) {
               return array(
                   'link' => $node->attr('href'),
                   'name' => trim($node->filter('span')->text())
               );
            });

            foreach ($modelList as $model) {
                $carModel = new CarModel();
                $carModel->setName($model['name']);
                $carModel->setAvByLinkName($model['link']);
                $carModel->setCarMark($carMark);

                $generationCrawler = $this->client->request('GET', $model['link']);

                $generationList = $generationCrawler->filter('.js-generation-container select option')->each(function (Crawler $node) {
                    if (trim($node->text()) !== 'Поколение') {
                        return trim($node->text());
                    }
                });

//                if ($count === 1) {
//                    dump($carModel);
//                    dump($generationList);exit();
//                }

                foreach ($generationList as $generation) {
                    if ($generation !== null) {
                        $carGeneration = new CarGeneration();
                        $carGeneration->setName($generation);
                        $carGeneration->setCarModel($carModel);

                        $this->em->persist($carGeneration);
                    }
                }

                $this->em->persist($carModel);
            }

            $this->em->persist($carMark);

            $count++;
        }

        $this->em->flush();

        $executionEndTime = microtime(true);

        // Result time of executing script
        $seconds = $executionEndTime - $executionStartTime;
        echo "This script took $seconds to execute.";
    }
}
