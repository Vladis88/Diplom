<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CarPrice
 * @package App\Entity
 * @ORM\Entity
 */
class CarPrice
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $byn;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $usd;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getbyn(): ?int
    {
        return $this->byn;
    }

    /**
     * @param int $BYN
     */
    public function setbyn(int $BYN): void
    {
        $this->byn = $BYN;
    }

    /**
     * @return int
     */
    public function getusd(): ?int
    {
        return $this->usd;
    }

    /**
     * @param int $USD
     */
    public function setuds(int $USD): void
    {
        $this->usd = $USD;
    }
}
