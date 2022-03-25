<?php

namespace App\Service\Delivery;

use App\Model\TransferInterface;

/**
 * Class SmsNotificationService
 */
class SmsNotificationService implements DeliveryInterface
{
    public const LOCAL_SERVICE_TAG = 'delivery.sms.service';

    /**
     * @param TransferInterface $transfer
     */
    public function transfer(TransferInterface $transfer): void
    {
        var_dump('SmsNotificationService');
    }
}
