<?php

namespace App\Service\Delivery;

use App\Entity\CarPost;
use App\Model\TransferInterface;
use Telegram\Bot\Api;

/**
 * Class TelegramNotificationService
 */
class TelegramNotificationService implements DeliveryInterface
{
    /**
     * @var Api
     */
    protected $client;

    /**
     * @var string
     */
    protected $chatId;

    /**
     * TelegramNotificationService constructor.
     *
     * @param string $apiKey
     *
     * @param string $chatId
     *
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function __construct(string $apiKey, string $chatId)
    {
        $this->client = new Api($apiKey);
        $this->chatId = $chatId;
    }


    /**
     * @param TransferInterface $transfer
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function transfer(TransferInterface $transfer): void
    {
        /** @var CarPost $carPost */
        $carPost = $transfer->getPost();

        $this->client->sendMessage(array(
            'chat_id' => $this->chatId,
            'text' => sprintf(
                "%s\n\Цена: %s\nСсылка: %s",
                $carPost->getTitle(),
                $carPost->getCarInfo()->getPrice()->getbyn(),
                $carPost->getLink()
            )
        ));
    }
}
