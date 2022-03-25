<?php

namespace App\Entity\ExtraOptions;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CarOpticsAndLightOption
 * @package App\Entity\ExtraOptions
 * @ORM\Entity
 */
class CarOpticsAndLightOption
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
     * @var mixed
     * @ORM\ManyToMany(targetEntity="App\Entity\CarInfo", inversedBy="carOpticsAndLightOptions")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $carInfos;

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
    public function getCarInfos()
    {
        return $this->carInfos;
    }

    /**
     * @param mixed $carInfos
     */
    public function setCarInfos($carInfos): void
    {
        $this->carInfos = $carInfos;
    }
}
