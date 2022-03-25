<?php

namespace App\Entity;

use App\Model\Vehicle\VehicleMarkInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CarMark
 * @package App\Entity
 * @ORM\Entity
 */
class CarMark implements VehicleMarkInterface
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
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $avByLinkName;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $nameFromLink;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->name;
    }

    /**
     * @return string
     */
    public function getNameFromLink(): ?string
    {
        return $this->nameFromLink;
    }

    /**
     * @param string $nameFromLink
     * @return CarMark
     */
    public function setNameFromLink(string $nameFromLink): CarMark
    {
        $this->nameFromLink = $nameFromLink;
        return $this;
    }

    /**
     * @var mixed
     * @ORM\OneToMany(targetEntity="App\Entity\CarModel", mappedBy="mark")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $models;

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
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @param mixed $models
     */
    public function setModels($models): void
    {
        $this->models = $models;
    }

    /**
     * @return string
     */
    public function getAvByLinkName(): ?string
    {
        return $this->avByLinkName;
    }

    /**
     * @param string $avByLinkName
     */
    public function setAvByLinkName(string $avByLinkName): void
    {
        $this->avByLinkName = $avByLinkName;
    }
}
