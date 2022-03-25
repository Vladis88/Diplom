<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SubscriptionService
 * @ORM\Entity
 */
class SubscriptionService
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $tag;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return SubscriptionService
     */
    public function setId(int $id): SubscriptionService
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     * @return SubscriptionService
     */
    public function setTag(string $tag): SubscriptionService
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return SubscriptionService
     */
    public function setTitle(?string $title): SubscriptionService
    {
        $this->title = $title;
        return $this;
    }
}
