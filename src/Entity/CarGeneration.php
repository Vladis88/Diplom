<?php

namespace App\Entity;

use App\Model\Vehicle\VehicleGenerationInterface;
use App\Model\Vehicle\VehicleModelInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CarGeneration
 * @package App\Entity
 * @ORM\Entity
 */
class CarGeneration implements VehicleGenerationInterface
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
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $fromYear;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    private $toYear;

    /**
     * @var CarModel
     * @ORM\ManyToOne(targetEntity="App\Entity\CarModel", inversedBy="generations")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $model;

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
     * @return VehicleModelInterface|null
     */
    public function getModel(): ?VehicleModelInterface
    {
        return $this->model;
    }

    /**
     * @param VehicleModelInterface $model
     * @return VehicleGenerationInterface
     */
    public function setModel(VehicleModelInterface $model): VehicleGenerationInterface
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFromYear(): ?string
    {
        return $this->fromYear->format('Y');
    }

    /**
     * @param \DateTime $fromYear
     * @return CarGeneration
     */
    public function setFromYear(\DateTime $fromYear): CarGeneration
    {
        $this->fromYear = $fromYear;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getToYear(): ?string
    {
        return $this->toYear->format('Y');
    }

    /**
     * @param \DateTime $toYear
     * @return CarGeneration
     */
    public function setToYear(\DateTime $toYear): CarGeneration
    {
        $this->toYear = $toYear;
        return $this;
    }
}
