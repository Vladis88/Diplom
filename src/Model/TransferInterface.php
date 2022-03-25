<?php

namespace App\Model;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface TransferInterface
 */
interface TransferInterface
{
    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface;

    /**
     * @return PostInterface
     */
    public function getPost(): PostInterface;

    /**
     * @return SubscriptionInterface
     */
    public function getSubscription(): SubscriptionInterface;
}
