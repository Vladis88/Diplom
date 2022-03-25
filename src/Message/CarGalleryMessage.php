<?php

namespace App\Message;

/**
 * Class CarGalleryMessage
 */
class CarGalleryMessage
{
    /**
     * @var integer
     */
    private $carPostId;

    /**
     * @var array
     */
    private $imageLinks;

    /**
     * CarGalleryMessage constructor.
     *
     * @param int $carPostId
     * @param array $imageLinks
     */
    public function __construct(int $carPostId, array $imageLinks)
    {
        $this->carPostId = $carPostId;
        $this->imageLinks = $imageLinks;
    }

    /**
     * @return int
     */
    public function getCarPostId(): ?int
    {
        return $this->carPostId;
    }

    /**
     * @return array
     */
    public function getImageLinks(): ?array
    {
        return $this->imageLinks;
    }
}
