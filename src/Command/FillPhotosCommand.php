<?php

namespace App\Command;

use App\Entity\CarPost;
use Clue\React\Buzz\Browser;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\LoopInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FillPhotosCommand
 * @package App\Command
 */
class FillPhotosCommand extends Command
{
    protected static $defaultName = "app:fill-photos";

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Browser
     */
    private $browser;

    /**
     * @var array
     */
    private $imagesQueue;

    /**
     * @var array
     */
    private $galleryForEveryCar;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    protected function configure()
    {
        $this->setDescription('Fill car post images');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loop = \React\EventLoop\Factory::create();
        $this->browser = new \Clue\React\Buzz\Browser($loop);

        /** @var CarPost[] $carPosts */
        $carPosts = $this->em->getRepository(CarPost::class)->findBy([
            'isActive' => false
        ]);

        foreach ($carPosts as $post) {
            $photoLink = $post->getPreviewImageLink();
            if ($photoLink === null)
                continue;
            $gallery = $post->getImagesLinks();

            // Create preview image name $this->imagesQueue
            $currentDate = new \DateTime('now');
            $previewImageName = "avto-" . $currentDate->format('Y-m-d_H:i:s.u');

            // Save binary image in
            $this->browser->get($photoLink)->then(
                function (ResponseInterface $response) use ($previewImageName) {
                    // store image
                    var_dump('HELLO');
                    $this->imagesQueue[$previewImageName] = (string) $response->getBody();
                },
                function () {
                    dump('REJECT');
                },
                function () {
                    dump('PROGRESS');
                }
            );

            $carGallery = array();

            foreach ($gallery as $item) {
                // Create preview image name $this->imagesQueue
                $currentDate = new \DateTime('now');
                $previewImageName1 = "avto-" . $currentDate->format('Y-m-d_H:i:s.u');

                // Save binary image in
                $this->browser->get($item)->then(
                    function (ResponseInterface $response) use ($previewImageName1, $previewImageName) {
                        // store image
                        var_dump('HELLO');
                        $this->galleryForEveryCar[$previewImageName][$previewImageName1] = (string) $response->getBody();
                    },
                    function () {
                        dump('REJECT');
                    },
                    function () {
                        dump('PROGRESS');
                    }
                );

                array_push($carGallery, $previewImageName1);
            }

            $post->setPreviewImage($previewImageName);
            $post->setImages($carGallery);
            $post->setIsActive(true);
            $this->em->persist($post);
            $this->em->flush();
            $this->em->refresh($post);

            if (!$post->getPreviewImage() || ($post->getImages() === null || count($post->getImages()) === 0)) {
                $post->setIsActive(false);
            }

            $this->em->persist($post);
            $this->em->flush();
        }

        $loop->run();

        $this->saveImages($this->imagesQueue);
    }

    /**
     * @param array $imagesQueue
     */
    private function saveImages(array $imagesQueue): void
    {
        foreach ($imagesQueue as $key => $image) {
            file_put_contents("public/images/" . $key . '.jpeg', $image);
            foreach ($this->galleryForEveryCar[$key] as $galKey => $item) {
                file_put_contents("public/images/" . $galKey . '.jpeg', $item);
            }
        }
    }
}
