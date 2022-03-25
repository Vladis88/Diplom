<?php

namespace App\Entity;

use App\Model\Vehicle\VehicleMarkInterface;
use App\Model\Vehicle\VehicleModelInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CarModel
 * @package App\Entity
 * @ORM\Entity
 */
class CarModel implements VehicleModelInterface
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
     * @var CarMark
     * @ORM\ManyToOne(targetEntity="App\Entity\CarMark", inversedBy="models")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $mark;

    /**
     * @var mixed
     * @ORM\OneToMany(targetEntity="App\Entity\CarGeneration", mappedBy="model")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $generations;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->name;
    }

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
    public function getGenerations()
    {
        return $this->generations;
    }

    /**
     * @param mixed $generations
     */
    public function setGenerations($generations): void
    {
        $this->generations = $generations;
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

    /**
     * @return string
     */
    public function getNameFromLink(): ?string
    {
        return $this->nameFromLink;
    }

    /**
     * @param string $nameFromLink
     */
    public function setNameFromLink(string $nameFromLink): void
    {
        $this->nameFromLink = $nameFromLink;
    }

    /**
     * @return VehicleMarkInterface|null
     */
    public function getMark(): ?VehicleMarkInterface
    {
        return $this->mark;
    }

    /**
     * @param VehicleMarkInterface $mark
     */
    public function setMark(VehicleMarkInterface $mark): void
    {
        $this->mark = $mark;
    }
}
