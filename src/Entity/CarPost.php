<?php

namespace App\Entity;

use App\Model\PostInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CarPost
 * @package App\Entity
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class CarPost implements PostInterface
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var CarInfo
     * @ORM\OneToOne(targetEntity="App\Entity\CarInfo", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $carInfo;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $sellerName;

    /**
     * @var string[]
     * @ORM\Column(type="array", nullable=true)
     */
    private $sellerPhones;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $link;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAtInSystem;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $previewImage;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $previewImageLink;

    /**
     * @var string[]
     * @ORM\Column(type="array", nullable=true)
     */
    private $imagesLinks;

    /**
     * @var string[]
     * @ORM\Column(type="array", nullable=true)
     */
    private $images;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isActive = false;

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
     * @return CarInfo
     */
    public function getCarInfo(): ?CarInfo
    {
        return $this->carInfo;
    }

    /**
     * @param CarInfo $carInfo
     */
    public function setCarInfo(CarInfo $carInfo): void
    {
        $this->carInfo = $carInfo;
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
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getSellerName(): ?string
    {
        return $this->sellerName;
    }

    /**
     * @param string $sellerName
     */
    public function setSellerName(string $sellerName): void
    {
        $this->sellerName = $sellerName;
    }

    /**
     * @return string[]
     */
    public function getSellerPhones(): ?array
    {
        return $this->sellerPhones;
    }

    /**
     * @param string[] $sellerPhones
     */
    public function setSellerPhones(array $sellerPhones): void
    {
        $this->sellerPhones = $sellerPhones;
    }

    /**
     * @return string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAtInSystem(): ?\DateTime
    {
        return $this->createdAtInSystem;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtInSystem(): void
    {
        $this->createdAtInSystem = new \DateTime('now');
    }

    /**
     * @return string
     */
    public function getPreviewImage(): ?string
    {
        return $this->previewImage;
    }

    /**
     * @param string $previewImage
     */
    public function setPreviewImage(string $previewImage): void
    {
        $this->previewImage = $previewImage;
    }

    /**
     * @return string
     */
    public function getPreviewImageLink(): ?string
    {
        return $this->previewImageLink;
    }

    /**
     * @param string $previewImageLink
     */
    public function setPreviewImageLink(?string $previewImageLink): void
    {
        $this->previewImageLink = $previewImageLink;
    }

    /**
     * @return bool
     */
    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return string[]
     */
    public function getImagesLinks(): ?array
    {
        return $this->imagesLinks;
    }

    /**
     * @param string[] $imagesLinks
     */
    public function setImagesLinks(array $imagesLinks): void
    {
        $this->imagesLinks = $imagesLinks;
    }

    /**
     * @return string[]
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    /**
     * @param string[] $images
     */
    public function setImages(array $images): void
    {
        $this->images = $images;
    }
}
