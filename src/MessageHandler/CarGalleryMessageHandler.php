<?php

namespace App\MessageHandler;

use App\Entity\CarPost;
use App\Message\CarGalleryMessage;
use App\Service\UploaderService\UploaderServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class CarGalleryMessageHandler
 */
class CarGalleryMessageHandler implements MessageHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UploaderServiceInterface
     */
    private $carUploaderService;

    /**
     * CarGalleryMessageHandler constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @param UploaderServiceInterface $carUploaderService
     */
    public function setDependencies(UploaderServiceInterface $carUploaderService): void
    {
        $this->carUploaderService = $carUploaderService;
    }

    /**
     * @param CarGalleryMessage $message
     */
    public function __invoke(CarGalleryMessage $message)
    {
        $carPost = $this->em->getRepository(CarPost::class)->find((int) $message->getCarPostId());

        if (!$carPost)
            return;

        $carImages = array();
        foreach ($carPost->getImagesLinks() as $link) {
           $carImages[] = $fileName = $this->carUploaderService->uploadOne(
                $carPost,
                file_get_contents($link)
            );
        }

        $carPost->setImages($carImages);
        $this->em->flush();
    }
}
