<?php

namespace App\Service\Delivery;

use App\Entity\CarPost;
use App\Model\TransferInterface;
use Pusher\Pusher;
use Pusher\PushNotifications\PushNotifications;

/**
 * Class PushNotificationService
 */
class PushNotificationService implements DeliveryInterface
{
    /**
     * @var Pusher
     */
    private $pusher;

    /**
     * @var PushNotifications
     */
    private $pushNotifications;

    /**
     * @var string
     */
    public const LOCAL_SERVICE_TAG = 'delivery.push.service';

    /**
     * PushNotificationService constructor.
     *
     * @param Pusher $pusher
     *
     * @param PushNotifications $pushNotifications
     */
    public function __construct(Pusher $pusher, PushNotifications $pushNotifications)
    {
        $this->pusher = $pusher;
        $this->pushNotifications = $pushNotifications;
    }

    /**
     * @param TransferInterface $transfer
     * @throws \Pusher\PusherException
     * @throws \Exception
     */
    public function transfer(TransferInterface $transfer): void
    {
        /** @var CarPost $post */
        $post = $transfer->getPost();
        $user = $transfer->getUser();
        $subscription = $transfer->getSubscription();

        $this->pusher->trigger(
            $user->getUsername() . '-' . $user->getId(),
            'new-car',
            array(
                'post' => array(
                    'id' => $post->getId(),
                    'title' => $post->getTitle(),
                    'carInfo' => array(
                        'mark' => $post->getCarInfo()->getMark()->getName(),
                        'model' => $post->getCarInfo()->getModel()->getName(),
                        'generation' => $post->getCarInfo()->getGeneration()->getName()
                    )
                )
            )
        );

        $response = $this->pushNotifications->publishToInterests(
            array($transfer->getUser()->getUsername()),
            array(
                "fcm" => array(
                    "notification" => array(
                        "title" => "Новое объявление",
                        "body" => $post->getTitle()
                    )
                ),
                "apns" => array("aps" => array(
                    "alert" => array(
                        "title" => "Новое объявление",
                        "body" => $post->getTitle()
                    )
                ))
            )
        );

        var_dump($response);
    }
}
