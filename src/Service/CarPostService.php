<?php

namespace App\Service;

use App\Entity\CarColor;
use App\Entity\CarEngine;
use App\Entity\CarGeneration;
use App\Entity\CarInfo;
use App\Entity\CarMark;
use App\Entity\CarMileageMeasure;
use App\Entity\CarModel;
use App\Entity\CarPost;
use App\Entity\CarPrice;
use App\Entity\CarTransmission;
use App\Message\CarGalleryMessage;
use App\Repository\CarBodyTypeRepository;
use App\Repository\CarEngineTypeRepository;
use App\Repository\CarShapeRepository;
use App\Service\UploaderService\UploaderServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class CarPostService
 * @package App\Service
 */
class CarPostService
{
    /**
     * @var string
     */
    private const FILE_PATH = 'public/images';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var CarEngineTypeRepository
     */
    private $carEngineTypeRepository;

    /**
     * @var CarBodyTypeRepository
     */
    private $carBodyTypeRepository;

    /**
     * @var CarShapeRepository
     */
    private $carShapeRepository;

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var UploaderServiceInterface
     */
    private $uploaderService;

    /**
     * @var UploaderServiceInterface
     */
    private $carUploaderService;

    /**
     * @param UploaderServiceInterface $uploaderService
     *
     * @param UploaderServiceInterface $carUploaderService
     */
    public function setUploaderServices(
        UploaderServiceInterface $uploaderService,
        UploaderServiceInterface $carUploaderService
    ) {
        $this->uploaderService = $uploaderService;
        $this->carUploaderService = $carUploaderService;
    }

    /**
     * CarPostService constructor.
     * @param EntityManagerInterface $em
     * @param CarEngineTypeRepository $carEngineTypeRepository
     * @param CarBodyTypeRepository $carBodyTypeRepository
     * @param CarShapeRepository $carShapeRepository
     * @param MessageBusInterface $messageBus
     */
    public function __construct(
        EntityManagerInterface $em,
        CarEngineTypeRepository $carEngineTypeRepository,
        CarBodyTypeRepository $carBodyTypeRepository,
        CarShapeRepository $carShapeRepository,
        MessageBusInterface $messageBus
    )
    {
        $this->em = $em;
        $this->carEngineTypeRepository = $carEngineTypeRepository;
        $this->carBodyTypeRepository = $carBodyTypeRepository;
        $this->carShapeRepository = $carShapeRepository;
        $this->messageBus = $messageBus;
    }

    /**
     * @param array $posts
     * @return array
     * @throws \Exception
     */
    public function save(array $posts)
    {
        $carPosts = array();

        foreach ($posts as $post) {
            $carPost = new CarPost();
            $carPost->setTitle($post['title']);
            $carPost->setDescription($post['description']);
            $carPost->setCreatedAt($post['createdAt']);
            $carPost->setSellerName($post['sellerName']);
            $carPost->setImagesLinks($post['images'] ? $post['images'] : array());
            try {
                $carPost->setPreviewImageLink($post['previewImageLink']);
            } catch (\Exception $e) {
                dump($e->getMessage());
                dump($post['carInfo']['previewImageLink']);
            }
            $carPost->setLink($post['link']);
            $carPost->setSellerPhones($post['sellerPhones']);

            $carInfo = new CarInfo();
            $carPrice = new CarPrice();
            $carEngine = new CarEngine();

            $carPrice->setBYN($post['price']);
            try {
                $carEngine->setType($this->carEngineTypeRepository->findOneByName($post['carInfo']['engine.type']));
            } catch (\Exception $e) {
                dump($e->getMessage());
                dump($post['link']);
            }
            try {
                $carEngine->setEngineCapacity($this->getEngineCapacity($post['carInfo']['engine.engineCapacity']));
            } catch (\Exception $e) {
                dump($e->getMessage());
            }

            $carInfo->setMark($this->em->getRepository(CarMark::class)->find($post['carInfo']['mark']));
            $carInfo->setModel($this->em->getRepository(CarModel::class)->find($post['carInfo']['model']));
            try {
                $carInfo->setGeneration($this->em->getRepository(CarGeneration::class)->find($post['carInfo']['generation']));
            } catch (\Exception $exception) {
                dump($exception->getMessage());
            }

            $carInfo->setPrice($carPrice);
            $carInfo->setEngine($carEngine);
            $carInfo->setBodyType($this->carBodyTypeRepository->findOneByName($post['carInfo']['bodyType']));
            $carInfo->setYear($post['carInfo']['year']);
            $carInfo->setMileage((int)filter_var($post['carInfo']['mileage'],FILTER_SANITIZE_NUMBER_INT));
            $carInfo->setMileageMeasure($this->getMileageMeasure($post['carInfo']['mileage']));
            $carInfo->setColor($this->em->getRepository(CarColor::class)->findOneBy([
                'name' => $post['carInfo']['color']
            ]));
            $carInfo->setTransmission($this->em->getRepository(CarTransmission::class)->findOneBy([
                'name' => $post['carInfo']['transmission']
            ]));
            $carInfo->setShape($this->carShapeRepository->findOneByName($post['carInfo']['shape']));

            $carPost->setCarInfo($carInfo);

            $this->em->persist($carPrice);
            $this->em->persist($carEngine);
            $this->em->persist($carPost);

            array_push($carPosts, $carPost);
        }

        $this->em->flush();

        return $carPosts;
    }

    /**
     * @param string $capacity
     * @return int
     */
    public function getEngineCapacity(string $capacity): int
    {
        $array = explode(' ', $capacity);
        $engineCapacity = (int) $array[0];

        return $engineCapacity;
    }

    /**
     * @param string $mileageMeasure
     * @return CarMileageMeasure
     */
    private function getMileageMeasure(string $mileageMeasure): CarMileageMeasure
    {
        return $this->em->getRepository(CarMileageMeasure::class)->findOneBy([
            'name' => 'км'
        ]);
    }

    /**
     * @param array $carPosts
     */
    public function saveImages(array $carPosts): void
    {
        /** @var CarPost $carPost */
        foreach ($carPosts as $carPost) {
            if ($carPost->getPreviewImageLink()) {
                $filename = $this->carUploaderService->uploadOne(
                    $carPost,
                    file_get_contents($carPost->getPreviewImageLink())
                );
                $carPost->setPreviewImage($filename);
            }

            if (\count($carPost->getImagesLinks()) > 0) {
                $this
                    ->messageBus
                    ->dispatch(
                        new CarGalleryMessage($carPost->getId(), $carPost->getImagesLinks())
                    );
            }
        }
        $this->em->flush();
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getLastPostsLinks(int $limit = 25): array
    {
        $carPosts = $this->em->getRepository(CarPost::class)->findBy(
            array(),
            array('createdAtInSystem' => 'DESC'),
            $limit
        );

        $links = array();

        /** @var CarPost $carPost */
        foreach ($carPosts as $carPost) {
            $links[] = $carPost->getLink();
        }

        return $links;
    }
}
