<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CarInfo
 * @package App\Entity
 * @ORM\Entity
 */
class CarInfo
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * @var integer
     * @ORM\Column(type="string")
     */
    private $year;

    /**
     * @var CarGeneration
     * @ORM\ManyToOne(targetEntity="App\Entity\CarGeneration")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $generation;

    /**
     * @var CarBodyType
     * @ORM\ManyToOne(targetEntity="App\Entity\CarBodyType")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $bodyType;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $modification;

    /**
     * @var CarShape
     * @ORM\ManyToOne(targetEntity="App\Entity\CarShape")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $shape;

    /**
     * @var CarPrice
     * @ORM\OneToOne(targetEntity="App\Entity\CarPrice")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $price;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $mileage;

    /**
     * @var CarMileageMeasure
     * @ORM\ManyToOne(targetEntity="App\Entity\CarMileageMeasure")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $mileageMeasure;

    /**
     * @var CarEngine
     * @ORM\OneToOne(targetEntity="App\Entity\CarEngine")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $engine;

    /**
     * @var CarTransmission
     * @ORM\ManyToOne(targetEntity="App\Entity\CarTransmission")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $transmission;

    /**
     * Тип привода
     *
     * @var CarDriveType
     * @ORM\ManyToOne(targetEntity="App\Entity\CarDriveType")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $driveType;

    /**
     * @var CarColor
     * @ORM\ManyToOne(targetEntity="App\Entity\CarColor")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $color;

    /**
     * @var CarTrimMaterial
     * @ORM\ManyToOne(targetEntity="App\Entity\CarTrimMaterial")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $interiorMaterial;

    /**
     * @var CarInteriorColor
     * @ORM\ManyToOne(targetEntity="App\Entity\CarInteriorColor")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $interiorColor;

    /**
     * @var CarExchange
     * @ORM\ManyToOne(targetEntity="App\Entity\CarExchange")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $exchange;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $exchangeNote;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $vinNumber;

    /**
     * @var mixed
     * @ORM\ManyToMany(targetEntity="App\Entity\ExtraOptions\CarSecurityOption", mappedBy="carInfos")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $carSecurityOptions;

    /**
     * @var mixed
     * @ORM\ManyToMany(targetEntity="App\Entity\ExtraOptions\CarInteriorOption", mappedBy="carInfos")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $carInteriorOptions;

    /**
     * @var mixed
     * @ORM\ManyToMany(targetEntity="App\Entity\ExtraOptions\CarClimateAndHeatingOption", mappedBy="carInfos")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $carClimateAndHeatingOptions;

    /**
     * @var mixed
     * @ORM\ManyToMany(targetEntity="App\Entity\ExtraOptions\CarComfortOption", mappedBy="carInfos")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $carComfortOptions;

    /**
     * @var mixed
     * @ORM\ManyToMany(targetEntity="App\Entity\ExtraOptions\CarMultimediaOption", mappedBy="carInfos")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $carMultimediaOptions;

    /**
     * @var mixed
     * @ORM\ManyToMany(targetEntity="App\Entity\ExtraOptions\CarOpticsAndLightOption", mappedBy="carInfos")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $carOpticsAndLightOptions;

    /**
     * @var mixed
     * @ORM\ManyToMany(targetEntity="App\Entity\ExtraOptions\CarHelpSystemsOption", mappedBy="carInfos")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $carHelpSystemsOptions;

    /**
     * @var mixed
     * @ORM\ManyToMany(targetEntity="App\Entity\ExtraOptions\CarExteriorOption", mappedBy="carInfos")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $carExteriorOptions;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $videoLink;

    /**
     * @var Region
     * @ORM\ManyToOne(targetEntity="App\Entity\Region")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $region;

    /**
     * @var City
     * @ORM\ManyToOne(targetEntity="App\Entity\City")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $city;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "";
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
     * @return CarMark
     */
    public function getMark(): ?CarMark
    {
        return $this->mark;
    }

    /**
     * @param CarMark $mark
     */
    public function setMark(CarMark $mark): void
    {
        $this->mark = $mark;
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
     */
    public function setModel(CarModel $model): void
    {
        $this->model = $model;
    }

    /**
     * @return int
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
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
     */
    public function setGeneration(CarGeneration $generation): void
    {
        $this->generation = $generation;
    }

    /**
     * @return CarBodyType
     */
    public function getBodyType(): ?CarBodyType
    {
        return $this->bodyType;
    }

    /**
     * @param CarBodyType $bodyType
     */
    public function setBodyType(CarBodyType $bodyType): void
    {
        $this->bodyType = $bodyType;
    }

    /**
     * @return string
     */
    public function getModification(): ?string
    {
        return $this->modification;
    }

    /**
     * @param string $modification
     */
    public function setModification(string $modification): void
    {
        $this->modification = $modification;
    }

    /**
     * @return CarShape
     */
    public function getShape(): ?CarShape
    {
        return $this->shape;
    }

    /**
     * @param CarShape $shape
     */
    public function setShape(?CarShape $shape): void
    {
        $this->shape = $shape;
    }

    /**
     * @return CarPrice
     */
    public function getPrice(): ?CarPrice
    {
        return $this->price;
    }

    /**
     * @param CarPrice $price
     */
    public function setPrice(CarPrice $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    /**
     * @param int $mileage
     */
    public function setMileage(int $mileage): void
    {
        $this->mileage = $mileage;
    }

    /**
     * @return CarMileageMeasure
     */
    public function getMileageMeasure(): ?CarMileageMeasure
    {
        return $this->mileageMeasure;
    }

    /**
     * @param CarMileageMeasure $mileageMeasure
     */
    public function setMileageMeasure(CarMileageMeasure $mileageMeasure): void
    {
        $this->mileageMeasure = $mileageMeasure;
    }

    /**
     * @return CarEngine
     */
    public function getEngine(): ?CarEngine
    {
        return $this->engine;
    }

    /**
     * @param CarEngine $engine
     */
    public function setEngine(CarEngine $engine): void
    {
        $this->engine = $engine;
    }

    /**
     * @return CarTransmission
     */
    public function getTransmission(): ?CarTransmission
    {
        return $this->transmission;
    }

    /**
     * @param CarTransmission $transmission
     */
    public function setTransmission(CarTransmission $transmission): void
    {
        $this->transmission = $transmission;
    }

    /**
     * @return CarDriveType
     */
    public function getDriveType(): ?CarDriveType
    {
        return $this->driveType;
    }

    /**
     * @param CarDriveType $driveType
     */
    public function setDriveType(CarDriveType $driveType): void
    {
        $this->driveType = $driveType;
    }

    /**
     * @return CarColor
     */
    public function getColor(): ?CarColor
    {
        return $this->color;
    }

    /**
     * @param CarColor $color
     */
    public function setColor(?CarColor $color): void
    {
        $this->color = $color;
    }

    /**
     * @return CarTrimMaterial
     */
    public function getInteriorMaterial(): ?CarTrimMaterial
    {
        return $this->interiorMaterial;
    }

    /**
     * @param CarTrimMaterial $interiorMaterial
     */
    public function setInteriorMaterial(CarTrimMaterial $interiorMaterial): void
    {
        $this->interiorMaterial = $interiorMaterial;
    }

    /**
     * @return CarInteriorColor
     */
    public function getInteriorColor(): ?CarInteriorColor
    {
        return $this->interiorColor;
    }

    /**
     * @param CarInteriorColor $interiorColor
     */
    public function setInteriorColor(CarInteriorColor $interiorColor): void
    {
        $this->interiorColor = $interiorColor;
    }

    /**
     * @return CarExchange
     */
    public function getExchange(): ?CarExchange
    {
        return $this->exchange;
    }

    /**
     * @param CarExchange $exchange
     */
    public function setExchange(CarExchange $exchange): void
    {
        $this->exchange = $exchange;
    }

    /**
     * @return string
     */
    public function getExchangeNote(): ?string
    {
        return $this->exchangeNote;
    }

    /**
     * @param string $exchangeNote
     */
    public function setExchangeNote(string $exchangeNote): void
    {
        $this->exchangeNote = $exchangeNote;
    }

    /**
     * @return string
     */
    public function getVinNumber(): ?string
    {
        return $this->vinNumber;
    }

    /**
     * @param string $vinNumber
     */
    public function setVinNumber(string $vinNumber): void
    {
        $this->vinNumber = $vinNumber;
    }

    /**
     * @return mixed
     */
    public function getCarSecurityOptions()
    {
        return $this->carSecurityOptions;
    }

    /**
     * @param mixed $carSecurityOptions
     */
    public function setCarSecurityOptions($carSecurityOptions): void
    {
        $this->carSecurityOptions = $carSecurityOptions;
    }

    /**
     * @return mixed
     */
    public function getCarInteriorOptions()
    {
        return $this->carInteriorOptions;
    }

    /**
     * @param mixed $carInteriorOptions
     */
    public function setCarInteriorOptions($carInteriorOptions): void
    {
        $this->carInteriorOptions = $carInteriorOptions;
    }

    /**
     * @return mixed
     */
    public function getCarClimateAndHeatingOptions()
    {
        return $this->carClimateAndHeatingOptions;
    }

    /**
     * @param mixed $carClimateAndHeatingOptions
     */
    public function setCarClimateAndHeatingOptions($carClimateAndHeatingOptions): void
    {
        $this->carClimateAndHeatingOptions = $carClimateAndHeatingOptions;
    }

    /**
     * @return mixed
     */
    public function getCarComfortOptions()
    {
        return $this->carComfortOptions;
    }

    /**
     * @param mixed $carComfortOptions
     */
    public function setCarComfortOptions($carComfortOptions): void
    {
        $this->carComfortOptions = $carComfortOptions;
    }

    /**
     * @return mixed
     */
    public function getCarMultimediaOptions()
    {
        return $this->carMultimediaOptions;
    }

    /**
     * @param mixed $carMultimediaOptions
     */
    public function setCarMultimediaOptions($carMultimediaOptions): void
    {
        $this->carMultimediaOptions = $carMultimediaOptions;
    }

    /**
     * @return mixed
     */
    public function getCarOpticsAndLightOptions()
    {
        return $this->carOpticsAndLightOptions;
    }

    /**
     * @param mixed $carOpticsAndLightOptions
     */
    public function setCarOpticsAndLightOptions($carOpticsAndLightOptions): void
    {
        $this->carOpticsAndLightOptions = $carOpticsAndLightOptions;
    }

    /**
     * @return mixed
     */
    public function getCarHelpSystemsOptions()
    {
        return $this->carHelpSystemsOptions;
    }

    /**
     * @param mixed $carHelpSystemsOptions
     */
    public function setCarHelpSystemsOptions($carHelpSystemsOptions): void
    {
        $this->carHelpSystemsOptions = $carHelpSystemsOptions;
    }

    /**
     * @return mixed
     */
    public function getCarExteriorOptions()
    {
        return $this->carExteriorOptions;
    }

    /**
     * @param mixed $carExteriorOptions
     */
    public function setCarExteriorOptions($carExteriorOptions): void
    {
        $this->carExteriorOptions = $carExteriorOptions;
    }

    /**
     * @return string
     */
    public function getVideoLink(): ?string
    {
        return $this->videoLink;
    }

    /**
     * @param string $videoLink
     */
    public function setVideoLink(string $videoLink): void
    {
        $this->videoLink = $videoLink;
    }

    /**
     * @return Region
     */
    public function getRegion(): ?Region
    {
        return $this->region;
    }

    /**
     * @param Region $region
     */
    public function setRegion(Region $region): void
    {
        $this->region = $region;
    }

    /**
     * @return City
     */
    public function getCity(): ?City
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity(City $city): void
    {
        $this->city = $city;
    }
}
