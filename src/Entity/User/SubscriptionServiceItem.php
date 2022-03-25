<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SubscriptionServiceItem
 * @ORM\Entity
 */
class SubscriptionServiceItem
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var SubscriptionService
     * @ORM\ManyToOne(targetEntity="App\Entity\User\SubscriptionService")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $service;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="subscriptionServices")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return SubscriptionServiceItem
     */
    public function setId(int $id): SubscriptionServiceItem
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return SubscriptionService
     */
    public function getService(): ?SubscriptionService
    {
        return $this->service;
    }

    /**
     * @param SubscriptionService $service
     * @return SubscriptionServiceItem
     */
    public function setService(SubscriptionService $service): SubscriptionServiceItem
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return SubscriptionServiceItem
     */
    public function setUser(User $user): SubscriptionServiceItem
    {
        $this->user = $user;
        return $this;
    }
}
