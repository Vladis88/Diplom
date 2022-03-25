<?php

namespace App\Model;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface SubscriptionInterface
 */
interface SubscriptionInterface
{
    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface;
}
