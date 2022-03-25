<?php

namespace App\Command;

use App\Entity\CarPost;
use App\Service\CarPostCrawlerService;
use App\Service\CarPostService;
use App\Service\SubscriptionResolverService;
use Clue\React\Buzz\Browser;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ParseCar
 * @package App\Command
 */
class ParseCar extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:parse-car';

    /**
     * @var Browser
     */
    private $browser;

    /**
     * @var CarPostService
     */
    private $carPostService;

    /**
     * @var CarPostCrawlerService
     */
    private $carPostCrawlerService;

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $symfonyFilesystem;

    /**
     * @var SubscriptionResolverService
     */
    private $subscriptionResolverService;

    /**
     * @var array
     */
    private $resultCars = [];

    /**
     * ParseCar constructor.
     * @param \Symfony\Component\Filesystem\Filesystem $symfonyFilesystem
     * @param CarPostService $carPostService
     * @param CarPostCrawlerService $carPostCrawlerService
     * @param SubscriptionResolverService $subscriptionResolverService
     */
    public function __construct(
        \Symfony\Component\Filesystem\Filesystem $symfonyFilesystem,
        CarPostService $carPostService,
        CarPostCrawlerService $carPostCrawlerService,
        SubscriptionResolverService $subscriptionResolverService
    )
    {
        parent::__construct();

        $this->symfonyFilesystem = $symfonyFilesystem;
        $this->carPostService = $carPostService;
        $this->carPostCrawlerService = $carPostCrawlerService;
        $this->subscriptionResolverService = $subscriptionResolverService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Parse posts of cars from av.by');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // fix start time for parsing
        $executionStartTime = microtime(true);

        $this->carPostCrawlerService->fillCarLinks();

        $loop = \React\EventLoop\Factory::create();
        $this->browser = new \Clue\React\Buzz\Browser($loop);

        var_dump($this->carPostCrawlerService->getCurrentCarLinks());

        foreach ($this->carPostCrawlerService->getCurrentCarLinks() as $url) {
            $this->browser->get($url)
                ->then(function (ResponseInterface $response) use ($url) {
                    $array = $this
                        ->carPostCrawlerService
                        ->extract((string)$response->getBody(), $url);
                    $array['link'] = $url;
                    $this->resultCars[] = $array;
                });
        }

        $loop->run();

        $posts = $this->carPostService->save($this->resultCars);
        $this->carPostService->saveImages($posts);

        $this->resolveSubscriptions($posts);

        $executionEndTime = microtime(true);

        // Result time of executing script
        $seconds = $executionEndTime - $executionStartTime;
        echo "\nThis script took $seconds to execute.\n";
    }

    /**
     * @param array $posts
     */
    private function resolveSubscriptions(array $posts)
    {
        /** @var CarPost $post */
        foreach ($posts as $post) {
            $this->subscriptionResolverService->resolveSubscription($post);
        }
    }
}
