<?php

namespace App\Model;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class TransferModel
 */
class TransferModel implements TransferInterface
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var PostInterface
     */
    private $post;

    /**
     * @var SubscriptionInterface
     */
    private $subscription;

    /**
     * TransferModel constructor.
     * @param UserInterface $user
     * @param PostInterface $post
     * @param SubscriptionInterface $subscription
     */
    public function __construct(
        UserInterface $user,
        PostInterface $post,
        SubscriptionInterface $subscription
    )
    {
        $this->user = $user;
        $this->post = $post;
        $this->subscription = $subscription;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @return PostInterface
     */
    public function getPost(): PostInterface
    {
        return $this->post;
    }

    /**
     * @return SubscriptionInterface
     */
    public function getSubscription(): SubscriptionInterface
    {
        return $this->subscription;
    }

    /**
     * @param UserInterface $user
     * @return TransferModel
     */
    public function setUser(UserInterface $user): TransferModel
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param PostInterface $post
     * @return TransferModel
     */
    public function setPost(PostInterface $post): TransferModel
    {
        $this->post = $post;
        return $this;
    }

    /**
     * @param SubscriptionInterface $subscription
     * @return TransferModel
     */
    public function setSubscription(SubscriptionInterface $subscription): TransferModel
    {
        $this->subscription = $subscription;
        return $this;
    }

}
