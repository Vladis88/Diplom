<?php

namespace App\Service\UploaderService;

/**
 * Class UploaderImageHelperInterface
 */
interface UploaderImageHelperInterface
{
    /**
     * @param string $file
     *
     * @return string
     */
    public function getImageExtension(string $file): string;

    /**
     * @param $entity
     *
     * @return string
     */
    public function generateFilename($entity): string;
}
