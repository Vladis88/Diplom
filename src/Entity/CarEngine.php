<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CarEngine
 * @package App\Entity
 * @ORM\Entity
 */
class CarEngine
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var CarEngineType
     * @ORM\ManyToOne(targetEntity="App\Entity\CarEngineType")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $type;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $engineCapacity;

    /**
     * @var string
     */
    private $engineCapacityHint = 'куб.см';

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $hybrid = false;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $gasEquipment = false;

    /**
     * @var CarGasEquipmentType
     * @ORM\ManyToOne(targetEntity="App\Entity\CarGasEquipmentType")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $gasEquipmentType;

    /**
     * For electric car
     *
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $powerReserve;

    /**
     * @var string
     */
    private $powerReserveHint = 'км';

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return CarEngine
     */
    public function setId(int $id): CarEngine
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return CarEngineType
     */
    public function getType(): ?CarEngineType
    {
        return $this->type;
    }

    /**
     * @param CarEngineType $type
     * @return CarEngine
     */
    public function setType(CarEngineType $type): CarEngine
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getEngineCapacity(): ?int
    {
        return $this->engineCapacity;
    }

    /**
     * @param int $engineCapacity
     * @return CarEngine
     */
    public function setEngineCapacity(int $engineCapacity): CarEngine
    {
        $this->engineCapacity = $engineCapacity;
        return $this;
    }

    /**
     * @return string
     */
    public function getEngineCapacityHint(): ?string
    {
        return $this->engineCapacityHint;
    }

    /**
     * @param string $engineCapacityHint
     * @return CarEngine
     */
    public function setEngineCapacityHint(string $engineCapacityHint): CarEngine
    {
        $this->engineCapacityHint = $engineCapacityHint;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHybrid(): ?bool
    {
        return $this->hybrid;
    }

    /**
     * @param bool $hybrid
     * @return CarEngine
     */
    public function setHybrid(bool $hybrid): CarEngine
    {
        $this->hybrid = $hybrid;
        return $this;
    }

    /**
     * @return bool
     */
    public function isGasEquipment(): ?bool
    {
        return $this->gasEquipment;
    }

    /**
     * @param bool $gasEquipment
     * @return CarEngine
     */
    public function setGasEquipment(bool $gasEquipment): CarEngine
    {
        $this->gasEquipment = $gasEquipment;
        return $this;
    }

    /**
     * @return CarGasEquipmentType
     */
    public function getGasEquipmentType(): ?CarGasEquipmentType
    {
        return $this->gasEquipmentType;
    }

    /**
     * @param CarGasEquipmentType $gasEquipmentType
     * @return CarEngine
     */
    public function setGasEquipmentType(CarGasEquipmentType $gasEquipmentType): CarEngine
    {
        $this->gasEquipmentType = $gasEquipmentType;
        return $this;
    }

    /**
     * @return int
     */
    public function getPowerReserve(): ?int
    {
        return $this->powerReserve;
    }

    /**
     * @param int $powerReserve
     * @return CarEngine
     */
    public function setPowerReserve(int $powerReserve): CarEngine
    {
        $this->powerReserve = $powerReserve;
        return $this;
    }

    /**
     * @return string
     */
    public function getPowerReserveHint(): ?string
    {
        return $this->powerReserveHint;
    }

    /**
     * @param string $powerReserveHint
     * @return CarEngine
     */
    public function setPowerReserveHint(string $powerReserveHint): CarEngine
    {
        $this->powerReserveHint = $powerReserveHint;
        return $this;
    }
}
