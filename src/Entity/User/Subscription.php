<?php

namespace App\Entity\User;

use App\Entity\CarGeneration;
use App\Entity\CarMark;
use App\Entity\CarModel;
use App\Model\SubscriptionInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Subscription
 * @ORM\Entity
 */
class Subscription implements SubscriptionInterface
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $user;

    /**
     * @var CarMark
     * @ORM\ManyToOne(targetEntity="App\Entity\CarMark")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $mark;

    /**
     * @var CarModel
     * @ORM\ManyToOne(targetEntity="App\Entity\CarModel")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $model;

    /**
     * @var CarGeneration
     * @ORM\ManyToOne(targetEntity="App\Entity\CarGeneration")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $generation;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Subscription
     */
    public function setId(int $id): Subscription
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Subscription
     */
    public function setUser(User $user): Subscription
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return CarMark
     */
    public function getMark(): ?CarMark
    {
        return $this->mark;
    }

    /**
     * @param CarMark $mark
     * @return Subscription
     */
    public function setMark(CarMark $mark): Subscription
    {
        $this->mark = $mark;
        return $this;
    }

    /**
     * @return CarModel
     */
    public function getModel(): ?CarModel
    {
        return $this->model;
    }

    /**
     * @param CarModel $model
     * @return Subscription
     */
    public function setModel(CarModel $model): Subscription
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return CarGeneration
     */
    public function getGeneration(): ?CarGeneration
    {
        return $this->generation;
    }

    /**
     * @param CarGeneration $generation
     * @return Subscription
     */
    public function setGeneration(CarGeneration $generation): Subscription
    {
        $this->generation = $generation;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}
