<?php

namespace App\Service;

use App\Entity\User\Subscription;
use App\Model\PostInterface;
use App\Model\TransferInterface;
use App\Model\TransferModel;
use App\Service\Delivery\DeliveryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SubscriptionResolverService
 */
class SubscriptionResolverService
{
    /**
     * @var array
     */
    private $deliveryServices = array();

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * SubscriptionResolverService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param DeliveryInterface $deliveryService
     */
    public function addDeliveryService(DeliveryInterface $deliveryService)
    {
        array_push($this->deliveryServices, $deliveryService);
    }

    /**
     * @param PostInterface $post
     */
    public function resolveSubscription(PostInterface $post)
    {
        $subscriptions = $this->entityManager->getRepository(Subscription::class)->findBy(
            array('active' => true)
        );

        foreach ($subscriptions as $subscription) {
            $conditionModel = $subscription->getModel() ? $subscription->getModel()  ===
                $post->getCarInfo()->getModel() : true;
            $conditionGeneration = $subscription->getGeneration() ? $subscription->getGeneration() ===
                $post->getCarInfo()->getGeneration() : true;
            if (
                ($subscription->getMark() === $post->getCarInfo()->getMark()) &&
                $conditionModel && $conditionGeneration
            ) {
                $this->deliverPost(
                    new TransferModel(
                        $subscription->getUser(),
                        $post,
                        $subscription
                    )
                );
            }
        }
    }

    private function deliverPost(TransferInterface $transfer)
    {
        $arrayResults = array_map(
            function (DeliveryInterface $deliveryService) use ($transfer) {
                $deliveryService->transfer($transfer);
            }, $this->deliveryServices
        );
    }
}
