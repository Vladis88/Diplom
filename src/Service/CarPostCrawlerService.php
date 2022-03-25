<?php

namespace App\Service;

use App\Entity\CarGeneration;
use App\Entity\CarMark;
use App\Entity\CarModel;
use App\Repository\CarMarkRepository;
use App\Repository\CarModelRepository;
use Clue\React\Buzz\Browser;
use Doctrine\ORM\EntityManagerInterface;
use Goutte\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class CarPostCrawlerService
 * @package App\Service
 */
class CarPostCrawlerService
{
    /**
     * @var Browser
     */
    private $browser;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var CarMarkRepository
     */
    private $carMarkRepository;

    /**
     * @var CarModelRepository
     */
    private $carModelRepository;

    /**
     * @var CarPostService
     */
    private $carPostService;

    /**
     * @var array
     */
    private $imagesQueue;

    /**
     * @var array
     */
    private $galleryForEveryCar;

    /**
     * @var array
     */
    private $currentCarLinks = [];

    /**
     * CarPostCrawlerService constructor.
     * @param CarPostService $carPostService
     * @param Client $client
     * @param EntityManagerInterface $em
     * @param CarMarkRepository $carMarkRepository
     * @param CarModelRepository $carModelRepository
     */
    public function __construct(
        CarPostService $carPostService,
        Client $client,
        EntityManagerInterface $em,
        CarMarkRepository $carMarkRepository,
        CarModelRepository $carModelRepository
    )
    {
        $loop = \React\EventLoop\Factory::create();
        $this->browser = new \Clue\React\Buzz\Browser($loop);

        $this->carPostService = $carPostService;
        $this->client = $client;
        $this->em = $em;
        $this->carMarkRepository = $carMarkRepository;
        $this->carModelRepository = $carModelRepository;
    }

    /**
     * @param string $body
     * @param string $url
     * @return array
     * @throws \Exception
     */
    public function extract(string $body, string $url): array
    {
        $crawler = new Crawler($body);

        try {
            $title = $crawler->filter('.card-title')->text();
        } catch (\Exception $exception) {
        }

        $createdAt = $crawler->filter('.card-about-item-dates > dl dd')->text();
        $price = $crawler->filter('.card-details .card-price-main-primary')->text();
        try {
            $previewImage = $crawler->filter('.card-gallery .fotorama a')->first()->attr('href');
            $images = $crawler->filter('.card-gallery .fotorama a')->each(function (Crawler $node, $i) {
                if ($i > 0) {
                    return $node->attr('href');
                }
            });
            array_splice($images, 0, 1);

        } catch (\Exception $exception) {
            $previewImage = null;
            $images = null;
        }

        try {
            $description = $crawler->filter('.card-description')->text();
        } catch (\Exception $exception) {
            $description = null;
        }

        $sellerName = $crawler->filter('.card-details h3.card-contacts-name')->text();

        $phonesNumbers = $crawler->filter('a.modal-choice-link')->each(function (Crawler $node, $i) {
            if ($node->attr('href') !== '#') {
                return $node->attr('href');
            }
        });

        // Create preview image name $this->imagesQueue
        $currentDate = new \DateTime('now');
        $previewImageName = "avto-" . $currentDate->format('Y-m-d_H:i:s.u');

        // Save binary image in
//        $this->browser->get($previewImage)->then(
//            function (ResponseInterface $response) use ($previewImageName) {
//                // store image
//                var_dump('HELLO');
//                $this->imagesQueue[$previewImageName] = (string) $response->getBody();
//            },
//            function () {
//                var_dump('REJECT');
//            },
//            function () {
//                var_dump('PROGRESS');
//            }
//        );

        // This method save binary images in $this->galleryForEveryCar
//        foreach ($images as $image) {
//            $this->browser->get($image)->then(
//                function (ResponseInterface $response) use ($previewImageName) {
//                    $currentDate = new \DateTime('now');
//                    $carGalleryImage = "avto-" . $currentDate->format('Y-m-d_H:i:s.u');
//                    $this->galleryForEveryCar[$previewImageName][$carGalleryImage] = 'HELLO';
//                }
//            );
//        }

        // Remove nullable values from $phoneNumbers
        foreach ($phonesNumbers as $key => $pn) {
            if ($pn === null)
                unset($phonesNumbers[$key]);
        }

        $array = [
            'title' => trim($title),
            'price' => (int)filter_var($price, FILTER_SANITIZE_NUMBER_INT),
            'description' => trim($description),
            'createdAt' => new \DateTime(),
            'previewImage' => trim($previewImage),
            'sellerName' => trim($sellerName),
            'sellerPhones' => $phonesNumbers,
            'images' => $images,
            'previewImageLink' => $previewImage,
            'carInfo' => $this->extractCarInfo($crawler, $url, trim($title))
        ];

        return $array;
    }

    /**
     * @param Crawler $crawler
     * @param string $url
     * @param string $title
     * @return array
     */
    private function extractCarInfo(Crawler $crawler, string $url, string $title): array
    {
        // extract mark, model and generation
        $mark = $this->extractMark($url);
        $model = $this->extractModel($url, $mark);

        $generation = $this->extractGeneration($title, $model);

        $carInfoArray = $crawler->filter('.card-info ul li')->each(function (Crawler $node) {
            $result = array();
            foreach (CarPostOptions::$carInfoData as $key => $carInfoDatum) {
                if (trim($node->filter('dl dt')->text()) === $key) {
                    $result[$carInfoDatum] = trim($node->filter('dl dd')->text());
                }
            }

            return $result;
        });

        $resultCarInfo = array();

        foreach ($carInfoArray as $item) {
            foreach ($item as $key => $i) {
                $resultCarInfo[$key] = $i;
            }
        }

        return array_merge($resultCarInfo, array(
            'mark' => $mark,
            'model' => $model,
            'generation' => $generation
        ));
    }

    /**
     * @param string $url
     * @return int
     */
    public function extractMark(string $url): int
    {
       $path = parse_url($url, PHP_URL_PATH);
       $array = explode('/', $path);

       /** @var CarMark $mark */
       $mark = $this->em->getRepository(CarMark::class)->findOneBy([
           'nameFromLink' => $array[1]
       ]);

       return $mark->getId();
    }

    /**
     * @param string $url
     * @param int $markId
     * @return int
     */
    public function extractModel(string $url, int $markId): int
    {
        $path = parse_url($url, PHP_URL_PATH);
        $array = explode('/', $path);

        /** @var CarModel $model */
        $model = $this->em->getRepository(CarModel::class)->findOneBy([
            'mark' => $markId,
            'nameFromLink' => $array[2]
        ]);

        return $model->getId();
    }

    /**
     * @param string $title
     * @param int $carModel
     * @return int|null
     */
    public function extractGeneration(string $title, int $carModel): ?int
    {
        $model = $this->em->getRepository(CarModel::class)->find($carModel);
        /** @var CarMark $mark */
        $mark = $model->getMark();
//        dump($title);
        $title = substr($title, 0, -6);

        $title = str_replace($mark->getName(), '', $title);
        $title = str_replace($model->getName(), '', $title);
        $title = trim($title);

//        dump($title);

        $titleItems = explode(' ', $title);
        $resultItems = array();

        foreach ($titleItems as $item) {
            if ($item === $model->getName() || $item === $mark->getName()) {
                continue;
            }

            array_push($resultItems, $item);
        }

        $variants = array();

        for ($i = count($resultItems); $i > 0; $i--) {
            array_push($variants, implode(' ', array_slice($resultItems, 0, $i)));
        }

        foreach ($variants as $variant) {
            $needle = $this->em->getRepository(CarGeneration::class)->findOneBy([
                'model' => $model,
                'name' => $variant
            ]);

            if ($needle) {
                return $needle->getId();
//                dump($needle);exit();
            }
        }

        return null;
    }

    public function fillCarLinks(): void
    {
        $carsPageLink = 'https://cars.av.by/search?sort=date&order=desc&year_from=&year_to=&currency=USD&price_from=&price_to=&body_id=&engine_volume_min=&engine_volume_max=&driving_id=&mileage_min=&mileage_max=&region_id=&interior_material=&interior_color=&exchange=&search_time=1';

        $crawler = $this->client->request('GET', $carsPageLink);

        $newLinks = $crawler->filter('.listing-item-title h4 > a')->each(function (Crawler $node) {
            return $node->attr('href');
        });

        $oldLinks = $this->carPostService->getLastPostsLinks();
        $newLinks = array_slice($newLinks, 0, 25);
        $diffLinks = array();

        for ($i = 0; $i < count($newLinks); $i++) {
            $flag = true;
            for ($j = 0; $j < count($oldLinks); $j++) {
                if ($newLinks[$i] === $oldLinks[$j]) {
                    $flag = false;
                }
            }
            if ($flag) {
                array_push($diffLinks, $newLinks[$i]);
            }
        }

        $this->currentCarLinks = array_slice($diffLinks, 0, 25);
    }

    /**
     * @return array
     */
    public function getImagesQueue(): ?array
    {
        return $this->imagesQueue;
    }

    /**
     * @return array
     */
    public function getGalleryForEveryCar(): ?array
    {
        return $this->galleryForEveryCar;
    }

    /**
     * @return array
     */
    public function getCurrentCarLinks(): ?array
    {
        return $this->currentCarLinks;
    }
}
