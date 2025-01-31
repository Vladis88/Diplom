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
use React\EventLoop\Loop;
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
    private Browser $browser;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var CarMarkRepository
     */
    private CarMarkRepository $carMarkRepository;

    /**
     * @var CarModelRepository
     */
    private CarModelRepository $carModelRepository;

    /**
     * @var CarPostService
     */
    private CarPostService $carPostService;

    /**
     * @var array
     */
    private array $imagesQueue;

    /**
     * @var array
     */
    private array $galleryForEveryCar;

    /**
     * @var array
     */
    private array $currentCarLinks = [];

    /**
     * CarPostCrawlerService constructor.
     * @param CarPostService $carPostService
     * @param Client $client
     * @param EntityManagerInterface $entityManager
     * @param CarMarkRepository $carMarkRepository
     * @param CarModelRepository $carModelRepository
     */
    public function __construct(
        CarPostService         $carPostService,
        Client                 $client,
        EntityManagerInterface $entityManager,
        CarMarkRepository      $carMarkRepository,
        CarModelRepository     $carModelRepository
    )
    {
        $loop = Loop::get();
        $this->browser = new Browser($loop);

        $this->carPostService = $carPostService;
        $this->client = $client;
        $this->entityManager = $entityManager;
        $this->carMarkRepository = $carMarkRepository;
        $this->carModelRepository = $carModelRepository;
    }

    /**
     * @param string $url
     * @return array
     * @throws \Exception
     */
    public function extract(string $url): array
    {
        $crawler = $this->client->request('GET', $url);

        $title = $crawler->filter('.card__header h1')->text();

        $price = $crawler->filter('.card__summary .card__price-primary')->text();
        try {
            $previewImage = $crawler->filter('.gallery .gallery__stage .gallery__stage-shaft .gallery__frame img')->eq(0)->attr('data-src');

            $images = $crawler->filter('.gallery .gallery__stage .gallery__stage-shaft .gallery__frame img')->each(
                function (Crawler $node) {
                    return $node->attr('data-src');
                }
            );
            array_splice($images, 0, 1);
            array_unshift($images, $previewImage);
        } catch (\Exception $exception) {
            $previewImage = null;
            $images = null;
        }

        try {
            $description = $crawler->filter('.card__comment-text p')->text();
        } catch (\Exception $exception) {
            $description = null;
        }

        //TODO нужно доразбираться как зайти в форму через нажатие кнопки для имени продовца и номера телефона
//        $sellerName = $crawler->selectButton('span.button__text')->form();
        $sellerName = 'SellerNameTest';

//        $phonesNumbers = $crawler->filter('a.modal-choice-link')->each(
//            function (Crawler $node, $i) {
//                if ($node->attr('href') !== '#') {
//                    return $node->attr('href');
//                }
//                throw new Exception('Not found phones numbers!');
//            }
//        );
        $phonesNumbers = ['phonesNumbersTest'];

        // Remove nullable values from $phoneNumbers
        foreach ($phonesNumbers as $key => $pn) {
            if ($pn === null)
                unset($phonesNumbers[$key]);
        }

        return [
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
        dump($generation);
        $carInfoArray = $crawler->filter('.card__about .card__params .card__description')->each(function (Crawler $node) {
            return $node->text();
        });
        dump($carInfoArray); exit();
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
        $mark = $this->entityManager->getRepository(CarMark::class)->findOneBy([
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
        $model = $this->entityManager->getRepository(CarModel::class)->findOneBy([
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
        $model = $this->entityManager->getRepository(CarModel::class)->find($carModel);
        /** @var CarMark $mark */
        $mark = $model->getMark();

        $titleItems = explode(' ', $title);
        $resultItems = array();

        array_shift($titleItems);
        array_pop($titleItems);
        foreach ($titleItems as $item) {
            if ($item === $model->getName() || $item === $mark->getName()) {
                continue;
            }
            $resultItems[] = $item;
        }

        $variants = array();
        for ($i = count($resultItems); $i > 0; $i--) {
            $variants[] = implode(' ', array_slice($resultItems, 0, $i));
        }
        dump($variants);
        foreach ($variants as $variant) {
            $variant = str_replace(array(',', ', ', ' ,'), '', $variant);

            $needle = $this->entityManager->getRepository(CarGeneration::class)->findOneBy([
                'model' => $model,
                'name' => $variant
            ]);
            if ($needle) {
                exit();
                return $needle->getId();
            }
        }
        return null;
    }

    public function fillCarLinks(): void
    {
        $carsPageLink = 'https://cars.av.by/';

        $crawler = $this->client->request('GET', $carsPageLink);

        $newLinks = $crawler->filter('.listing-top__summary h3 > a')->each(function (Crawler $node) {
            return 'https://cars.av.by' . $node->attr('href');
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
                $diffLinks[] = $newLinks[$i];
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
