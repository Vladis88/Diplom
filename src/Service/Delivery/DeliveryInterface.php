<?php

namespace App\Service\Delivery;

use App\Model\TransferInterface;

/**
 * Interface DeliveryInterface
 */
interface DeliveryInterface
{
    /**
     * @var string
     */
    public const DELIVERY_TAG = 'delivery.service';

    /**
     * @param TransferInterface $transfer
     */
    public function transfer(TransferInterface $transfer): void;
}
